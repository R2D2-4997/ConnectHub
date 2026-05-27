<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nom) && isset($data->createur_id)) {
    $nom = mysqli_real_escape_string($conn, $data->nom);
    $desc = mysqli_real_escape_string($conn, $data->description);
    $createur_id = (int)$data->createur_id;

    // 1. Création de la communauté
    $sqlGroup = "INSERT INTO communautes (Nom, Description, Createur_ID) VALUES ('$nom', '$desc', $createur_id)";
    
    if (mysqli_query($conn, $sqlGroup)) {
        $communaute_id = mysqli_insert_id($conn);
        
        // 2. Code en dur : On lie immédiatement le créateur en tant que Modérateur
        mysqli_query($conn, "INSERT INTO membres_communautes (Utilisateur_ID, Communaute_ID, Role_Communaute, Statut) 
                             VALUES ($createur_id, $communaute_id, 'Moderateur', 'Accepte')");
        
        echo json_encode(["succes" => "Communauté créée et droits accordés !"]);
    } else {
        echo json_encode(["erreur" => mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>