<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Vérification stricte du rôle en BDD
$check = mysqli_query($conn, "SELECT Role FROM Utilisateurs WHERE ID = $user_id");
$user = mysqli_fetch_assoc($check);

if ($user && $user['Role'] === 'Moderateur') {
    $sql = "SELECT s.ID, s.Motif, s.Date_Signalement, p.Contenu AS PostContenu, p.ID AS PubID, u.Nom AS AuteurNom 
            FROM Signalements s
            JOIN Publications p ON s.Publication_ID = p.ID
            JOIN Utilisateurs u ON p.Auteur_ID = u.ID
            WHERE s.Statut = 'En_Attente'
            ORDER BY s.Date_Signalement DESC";
            
    $result = mysqli_query($conn, $sql);
    $signalements = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $signalements[] = $row;
    }
    echo json_encode($signalements);
} else {
    echo json_encode(["erreur" => "Accès interdit. Réservé aux modérateurs."]);
}
mysqli_close($conn);
?>