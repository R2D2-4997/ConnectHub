<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));
if (isset($data->communaute_id) && isset($data->cible_id)) {
    mysqli_query($conn, "DELETE FROM membres_communautes WHERE Communaute_ID = " . (int)$data->communaute_id . " AND Utilisateur_ID = " . (int)$data->cible_id);
    echo json_encode(["succes" => "Membre exclu avec succès."]);
}
?>