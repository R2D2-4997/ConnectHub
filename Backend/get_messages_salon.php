<?php
require_once("config.php");
$salon_id = isset($_GET['salon_id']) ? (int)$_GET['salon_id'] : 0;

$sql = "SELECT msgs.ID, msgs.Contenu, msgs.Expediteur_ID, msgs.Date_Envoi, u.Nom AS Expediteur_Nom 
        FROM messages_salons msgs 
        JOIN utilisateurs u ON msgs.Expediteur_ID = u.ID 
        WHERE msgs.Salon_ID = $salon_id 
        ORDER BY msgs.Date_Envoi ASC";

$result = mysqli_query($conn, $sql);
$messages = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $messages[] = $row; }
}
echo json_encode($messages);
mysqli_close($conn);
?>