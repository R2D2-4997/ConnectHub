<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));
if (isset($data->communaute_id)) {
    // Grâce au ON DELETE CASCADE dans votre BDD, supprimer la communauté supprimera ses posts et membres
    mysqli_query($conn, "DELETE FROM communautes WHERE ID = " . (int)$data->communaute_id);
    echo json_encode(["succes" => "Hub supprimé."]);
}
?>