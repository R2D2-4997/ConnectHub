<?php
require_once("config.php");
$c_id = isset($_GET['communaute_id']) ? (int)$_GET['communaute_id'] : 0;

$sql = "SELECT u.ID, u.Nom, mc.Role_Communaute 
        FROM membres_communautes mc 
        JOIN utilisateurs u ON mc.Utilisateur_ID = u.ID 
        WHERE mc.Communaute_ID = $c_id AND mc.Statut = 'Accepte'
        ORDER BY mc.Role_Communaute DESC, u.Nom ASC";

$result = mysqli_query($conn, $sql);
$membres = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $membres[] = $row;
    }
    echo json_encode($membres);
} else {
    echo json_encode(["erreur" => mysqli_error($conn)]);
}
mysqli_close($conn);
?>