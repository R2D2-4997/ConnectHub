<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));
if (isset($data->communaute_id) && isset($data->utilisateur_id)) {
    mysqli_query($conn, "DELETE FROM membres_communautes WHERE Communaute_ID = " . (int)$data->communaute_id . " AND Utilisateur_ID = " . (int)$data->utilisateur_id);
    echo json_encode(["succes" => "Vous avez quitté le Hub."]);
}
?>