<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->utilisateur_id)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->utilisateur_id;

    // Sécurité : Vérification de la correspondance de l'auteur avant suppression
    $delete = mysqli_query($conn, "DELETE FROM publications WHERE ID = $pub_id AND Auteur_ID = $user_id");
    
    if ($delete) {
        echo json_encode(["succes" => "Publication effacée avec succès !"]);
    } else {
        echo json_encode(["erreur" => "Impossible de supprimer la publication : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>