<?php
require_once("config.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$visiteur_id = isset($_GET['visiteur']) ? (int)$_GET['visiteur'] : 0;

$response = ["utilisateur" => null, "publications" => []];

if ($id > 0) {
    // 1. Récupération des infos de l'utilisateur et des statistiques d'abonnement
    $sql_user = "SELECT u.ID, u.Nom, u.Email, u.Role, u.Photo_Profil,
        (SELECT COUNT(*) FROM abonnements WHERE Suivi_ID = u.ID) AS NbAbonnes,
        (SELECT COUNT(*) FROM abonnements WHERE Suiveur_ID = u.ID) AS NbAbonnements,
        (SELECT COUNT(*) FROM abonnements WHERE Suiveur_ID = $visiteur_id AND Suivi_ID = u.ID) AS EstAbonne
        FROM utilisateurs u WHERE u.ID = $id";
        
    $res_user = mysqli_query($conn, $sql_user);
    if ($res_user && mysqli_num_rows($res_user) > 0) {
        $response["utilisateur"] = mysqli_fetch_assoc($res_user);
    } else {
        echo json_encode(["erreur" => "Utilisateur introuvable."]);
        exit;
    }

    // 2. Récupération des publications (INCLUANT Est_Epingle)
    $sql_pubs = "SELECT p.ID, p.Auteur_ID, u.Nom, p.Contenu, p.Media_URL, p.Date_Publication, p.Est_Epingle,
        (SELECT COUNT(*) FROM likes WHERE Publication_ID = p.ID) AS NbLikes
        FROM publications p
        JOIN utilisateurs u ON p.Auteur_ID = u.ID
        WHERE p.Auteur_ID = $id
        ORDER BY p.Date_Publication DESC";
        
    $res_pubs = mysqli_query($conn, $sql_pubs);
    if ($res_pubs) {
        while ($row = mysqli_fetch_assoc($res_pubs)) {
            $response["publications"][] = $row;
        }
    } else {
        $response["erreur_sql"] = mysqli_error($conn);
    }
} else {
    $response["erreur"] = "ID invalide.";
}

echo json_encode($response);
mysqli_close($conn);
?>