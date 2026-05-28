<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$sql = "SELECT e.ID, e.Titre, e.Date_Evenement, e.Lieu 
        FROM evenements e 
        JOIN participants_evenements pe ON e.ID = pe.Evenement_ID 
        WHERE pe.Utilisateur_ID = $user_id";

$result = mysqli_query($conn, $sql);
$evts = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $evts[] = $row;
    }
    echo json_encode($evts);
} else {
    echo json_encode(["erreur" => mysqli_error($conn)]);
}
mysqli_close($conn);
?>