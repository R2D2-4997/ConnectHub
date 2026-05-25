<?php
require_once("config.php");

$profil_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$visiteur_id = isset($_GET['visiteur']) ? (int)$_GET['visiteur'] : 0;

if ($profil_id > 0) {
    // 1. Récupérer les informations et statistiques de l'utilisateur ciblé
    $sql_user = "SELECT ID, Nom, Role, 
                (SELECT COUNT(*) FROM Abonnements WHERE Suivi_ID = $profil_id) AS NbAbonnes,
                (SELECT COUNT(*) FROM Abonnements WHERE Suiveur_ID = $profil_id) AS NbAbonnements,
                (SELECT COUNT(*) FROM Abonnements WHERE Suiveur_ID = $visiteur_id AND Suivi_ID = $profil_id) AS EstAbonne
                FROM Utilisateurs WHERE ID = $profil_id";
    
    $res_user = mysqli_query($conn, $sql_user);
    $user = mysqli_fetch_assoc($res_user);

    // 2. Récupérer uniquement les publications de cet utilisateur
    $sql_pubs = "SELECT p.ID, u.Nom, p.Contenu, p.Media_URL, p.Date_Publication, p.Auteur_ID,
                (SELECT COUNT(*) FROM Likes WHERE Publication_ID = p.ID) as NbLikes
                FROM Publications p 
                JOIN Utilisateurs u ON p.Auteur_ID = u.ID 
                WHERE p.Auteur_ID = $profil_id
                ORDER BY p.Date_Publication DESC";
    
    $res_pubs = mysqli_query($conn, $sql_pubs);
    $publications = [];
    while($row = mysqli_fetch_assoc($res_pubs)) {
        $row['EstAbonne'] = $user['EstAbonne']; // On force ce booléen pour réutiliser l'affichage React existant
        $publications[] = $row;
    }

    echo json_encode(["utilisateur" => $user, "publications" => $publications]);
} else {
    echo json_encode(["erreur" => "ID d'utilisateur manquant."]);
}
mysqli_close($conn);
?>