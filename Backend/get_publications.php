<?php
require_once("config.php");

// Requête SQL avec jointure pour lier le message à son auteur
$sql = "SELECT p.ID, u.Nom, p.Contenu, p.Date_Publication, 
        (SELECT COUNT(*) FROM Likes WHERE Publication_ID = p.ID) as NbLikes
        FROM Publications p 
        JOIN Utilisateurs u ON p.Auteur_ID = u.ID 
        ORDER BY p.Date_Publication DESC";

$result = mysqli_query($conn, $sql);
$publications = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $publications[] = $row;
    }
    echo json_encode($publications);
} else {
    echo json_encode(["erreur" => "Impossible de charger le fil d'actualité : " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>