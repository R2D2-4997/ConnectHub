<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->user1) && isset($data->user2)) {
    $u1 = (int) $data->user1;
    $u2 = (int) $data->user2;

    $sql = "SELECT m.*, u.Nom AS ExpediteurNom 
            FROM Messages_Prives m
            JOIN Utilisateurs u ON m.Expediteur_ID = u.ID
            WHERE (Expediteur_ID = $u1 AND Destinataire_ID = $u2)
               OR (Expediteur_ID = $u2 AND Destinataire_ID = $u1)
            ORDER BY Date_Envoi ASC";

    $res = mysqli_query($conn, $sql);
    $messages = [];

    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $messages[] = $row;
        }
        echo json_encode($messages);
    } else {
        echo json_encode(["erreur" => mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>