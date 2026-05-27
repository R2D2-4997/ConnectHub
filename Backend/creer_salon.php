<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->nom) && isset($data->createur_id) && !empty($data->membres)) {
    $nom = mysqli_real_escape_string($conn, $data->nom);
    $createur_id = (int)$data->createur_id;

    // Créer le salon
    mysqli_query($conn, "INSERT INTO salons_prives (Nom, Createur_ID) VALUES ('$nom', $createur_id)");
    $salon_id = mysqli_insert_id($conn);

    // Ajouter le créateur
    mysqli_query($conn, "INSERT INTO membres_salons (Salon_ID, Utilisateur_ID) VALUES ($salon_id, $createur_id)");

    // Ajouter les invités
    foreach ($data->membres as $membre_id) {
        $m_id = (int)$membre_id;
        mysqli_query($conn, "INSERT IGNORE INTO membres_salons (Salon_ID, Utilisateur_ID) VALUES ($salon_id, $m_id)");
    }
    
    echo json_encode(["succes" => "Groupe créé avec succès !"]);
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>