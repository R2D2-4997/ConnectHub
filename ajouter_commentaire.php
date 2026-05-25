<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->auteur_id) && isset($data->contenu)) {
    $pub_id = (int) $data->publication_id;
    $auteur_id = (int) $data->auteur_id;
    $contenu = mysqli_real_escape_string($conn, htmlspecialchars($data->contenu));

    $sql = "INSERT INTO Commentaires (Publication_ID, Auteur_ID, Contenu) 
            VALUES ($pub_id, $auteur_id, '$contenu')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Commentaire ajouté avec succès !"]);
    } else {
        echo json_encode(["erreur" => "Erreur : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}

mysqli_close($conn);
?>