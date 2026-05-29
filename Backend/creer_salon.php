<?php
require_once("config.php");
mysqli_set_charset($conn, "utf8mb4");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->nom) && isset($data->createur_id)) {
    $nom = mysqli_real_escape_string($conn, $data->nom);
    $createur = (int)$data->createur_id;
    
    // CORRECTION ICI : On utilise bien la table salons_prives présente dans votre base de données
    $sql = "INSERT INTO salons_prives (Nom, Createur_ID) VALUES ('$nom', $createur)";
    
    if (mysqli_query($conn, $sql)) {
        // On récupère l'ID du salon nouvellement créé
        $salon_id = mysqli_insert_id($conn);
        $membres = isset($data->membres) ? $data->membres : [];
        
        // On insère chaque membre dans la table membres_salons
        foreach ($membres as $membre_id) {
            $mid = (int)$membre_id;
            mysqli_query($conn, "INSERT INTO membres_salons (Salon_ID, Utilisateur_ID) VALUES ($salon_id, $mid)");
        }
        
        echo json_encode(["succes" => "Groupe créé avec succès."]);
    } else {
        // Si erreur SQL, on la renvoie proprement en JSON
        echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes."]);
}
?>