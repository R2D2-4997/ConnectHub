<?php
require_once("config.php");
$communaute_id = isset($_GET['communaute_id']) ? (int)$_GET['communaute_id'] : 0;

$sql = "SELECT d.ID, d.Titre, d.Contenu, d.Score, DATE_FORMAT(d.Date_Creation, '%d/%m/%Y %H:%i') AS DateF, u.Nom AS Auteur
        FROM discussions_communaute d
        JOIN utilisateurs u ON d.Auteur_ID = u.ID
        WHERE d.Communaute_ID = $communaute_id
        ORDER BY d.Score DESC, d.Date_Creation DESC";

$result = mysqli_query($conn, $sql);
$discussions = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $discussions[] = $row; }
    echo json_encode($discussions);
} else {
    echo json_encode(["erreur" => mysqli_error($conn)]);
}
mysqli_close($conn);
?>