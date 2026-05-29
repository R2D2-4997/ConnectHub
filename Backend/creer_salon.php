<?php
require_once("config.php");
// FIX CARACTÈRES SPÉCIAUX :
mysqli_set_charset($conn, "utf8mb4");

$data = json_decode(file_get_contents("php://input"));
if (isset($data->nom) && isset($data->createur_id)) {
    // Protection des apostrophes et caractères spéciaux
    $nom = mysqli_real_escape_string($conn, $data->nom);
    $createur = (int)$data->createur_id;
    
    $sql = "INSERT INTO salons (Nom, Createur_ID) VALUES ('$nom', $createur)";
    if (mysqli_query($conn, $sql)) {
        $salon_id = mysqli_insert_id($conn);
        $membres = isset($data->membres) ? $data->membres : [];
        
        // On boucle pour ajouter chaque membre coché + le créateur
        foreach ($membres as $membre_id) {
            $mid = (int)$membre_id;
            mysqli_query($conn, "INSERT INTO membres_salons (Salon_ID, Utilisateur_ID) VALUES ($salon_id, $mid)");
        }
        echo json_encode(["succes" => "Groupe créé avec succès."]);
    } else {
        echo json_encode(["erreur" => "Erreur création : " . mysqli_error($conn)]);
    }
}
?>