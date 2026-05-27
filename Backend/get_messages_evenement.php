<?php
require_once("config.php");
$evt_id = isset($_GET['evenement_id']) ? (int)$_GET['evenement_id'] : 0;

$sql = "SELECT me.ID, me.Contenu, me.Date_Envoi, me.Expediteur_ID, u.Nom AS Expediteur_Nom 
        FROM messages_evenements me
        JOIN utilisateurs u ON me.Expediteur_ID = u.ID
        WHERE me.Evenement_ID = $evt_id
        ORDER BY me.Date_Envoi ASC";

$result = mysqli_query($conn, $sql);
$messages = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
}
echo json_encode($messages);
mysqli_close($conn);
?>