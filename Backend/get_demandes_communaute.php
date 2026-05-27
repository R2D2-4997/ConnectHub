<?php
require_once("config.php");
$c_id = isset($_GET['communaute_id']) ? (int)$_GET['communaute_id'] : 0;

$sql = "SELECT u.ID, u.Nom 
        FROM membres_communautes mc 
        JOIN utilisateurs u ON mc.Utilisateur_ID = u.ID 
        WHERE mc.Communaute_ID = $c_id AND mc.Statut = 'En_Attente'
        ORDER BY mc.Date_Demande ASC";

$result = mysqli_query($conn, $sql);
$demandes = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $demandes[] = $row;
    }
    echo json_encode($demandes);
} else {
    echo json_encode(["erreur" => mysqli_error($conn)]);
}
mysqli_close($conn);
?>