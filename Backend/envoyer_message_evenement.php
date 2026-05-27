<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->evenement_id) && isset($data->expediteur_id) && !empty($data->contenu)) {
    $evt_id = (int)$data->evenement_id;
    $user_id = (int)$data->expediteur_id;
    $contenu = mysqli_real_escape_string($conn, $data->contenu);

    $insert = mysqli_query($conn, "INSERT INTO messages_evenements (Evenement_ID, Expediteur_ID, Contenu) VALUES ($evt_id, $user_id, '$contenu')");
    
    if ($insert) {
        echo json_encode(["succes" => "Message de groupe envoyé !"]);
    } else {
        echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>