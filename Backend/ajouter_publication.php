<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

// Vérification de la présence des données
if (isset($data->contenu) && isset($data->auteur_id)) {
    
    // Sécurisation
    $contenu = mysqli_real_escape_string($conn, htmlspecialchars($data->contenu));
    $auteur_id = (int) $data->auteur_id;

    // Insertion
    $sql = "INSERT INTO Publications (Auteur_ID, Contenu) VALUES ($auteur_id, '$contenu')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Publication partagée avec succès !"]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de la publication : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Message vide ou utilisateur non identifié."]);
}

mysqli_close($conn);
?>