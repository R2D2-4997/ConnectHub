<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->utilisateur_id) && !empty($data->contenu)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->utilisateur_id;
    $contenu = mysqli_real_escape_string($conn, $data->contenu);

    // Sécurité : Modification restreinte à l'auteur d'origine
    $update = mysqli_query($conn, "UPDATE publications SET Contenu = '$contenu' WHERE ID = $pub_id AND Auteur_ID = $user_id");
    
    if ($update) {
        echo json_encode(["succes" => "Publication mise à jour !"]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de la modification : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes ou invalides."]);
}
mysqli_close($conn);
?>