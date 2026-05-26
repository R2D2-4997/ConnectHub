<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->signaleur_id) && isset($data->motif)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->signaleur_id;
    $motif = mysqli_real_escape_string($conn, htmlspecialchars($data->motif));

    $sql = "INSERT INTO Signalements (Publication_ID, Signaleur_ID, Motif) VALUES ($pub_id, $user_id, '$motif')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Contenu signalé aux modérateurs."]);
    } else {
        echo json_encode(["erreur" => mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>