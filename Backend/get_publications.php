<?php
require_once("config.php");

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$flux = isset($_GET['flux']) ? $_GET['flux'] : 'recommandations';

$condition = "";
// Si l'utilisateur demande ses abonnements, on filtre les auteurs
if ($flux === 'abonnes' && $user_id > 0) {
    $condition = "WHERE p.Auteur_ID IN (SELECT Suivi_ID FROM Abonnements WHERE Suiveur_ID = $user_id) OR p.Auteur_ID = $user_id";
}

$sql = "SELECT p.ID, u.Nom, p.Contenu, p.Media_URL, p.Date_Publication, p.Auteur_ID,
        (SELECT COUNT(*) FROM Likes WHERE Publication_ID = p.ID) as NbLikes,
        (SELECT COUNT(*) FROM Abonnements WHERE Suiveur_ID = $user_id AND Suivi_ID = p.Auteur_ID) as EstAbonne
        FROM Publications p 
        JOIN Utilisateurs u ON p.Auteur_ID = u.ID 
        $condition
        ORDER BY p.Date_Publication DESC";

$result = mysqli_query($conn, $sql);
$publications = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $row['EstAbonne'] = $row['EstAbonne'] > 0;
        $publications[] = $row;
    }
    echo json_encode($publications);
} else {
    echo json_encode(["erreur" => mysqli_error($conn)]);
}
mysqli_close($conn);
?>