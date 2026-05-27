<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->notif_id)) {
    $id = (int)$data->notif_id;
    // On efface la notification pour garder la base de données propre
    mysqli_query($conn, "DELETE FROM notifications WHERE ID = $id");
    echo json_encode(["succes" => "Notification supprimée"]);
} else {
    echo json_encode(["erreur" => "ID manquant"]);
}
mysqli_close($conn);
?>