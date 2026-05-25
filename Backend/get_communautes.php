<?php
require_once("config.php");

$sql = "SELECT c.ID, c.Nom, c.Description, u.Nom AS Createur, 
        (SELECT COUNT(*) FROM Membres_Communautes WHERE Communaute_ID = c.ID) AS NbMembres
        FROM Communautes c
        JOIN Utilisateurs u ON c.Createur_ID = u.ID
        ORDER BY c.Date_Creation DESC";

$result = mysqli_query($conn, $sql);
$communautes = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $communautes[] = $row;
    }
    echo json_encode($communautes);
} else {
    echo json_encode(["erreur" => "Impossible de charger les communautés : " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>