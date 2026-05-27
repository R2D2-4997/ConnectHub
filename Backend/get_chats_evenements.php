<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Récupération des événements auxquels l'athlète participe
$sql = "SELECT e.ID, e.Titre FROM evenements e
        JOIN participants_evenements pe ON e.ID = pe.Evenement_ID
        WHERE pe.Utilisateur_ID = $user_id
        ORDER BY e.Date_evenement ASC";

$result = mysqli_query($conn, $sql);
$evenements = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $evenements[] = $row;
    }
}
echo json_encode($evenements);
mysqli_close($conn);
?>