<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));
if (isset($data->discussion_id) && isset($data->auteur_id) && isset($data->contenu)) {
    $discId = (int)$data->discussion_id; $auteurId = (int)$data->auteur_id; $contenu = mysqli_real_escape_string($conn, $data->contenu);
    mysqli_query($conn, "INSERT INTO commentaires (Publication_ID, Auteur_ID, Contenu) VALUES ($discId, $auteurId, '$contenu')");
    // (Note : on réutilise la table commentaires, assurez-vous qu'elle puisse lier un commentaire à une discussion)
    echo json_encode(["succes" => "Réponse ajoutée."]);
}
?>