<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id > 0) {
    // 1. On récupère les notifications
    $sql = "SELECT n.ID, n.Type_Action, n.Lu, n.Date_Notification, u.Nom AS ActeurNom 
            FROM Notifications n
            JOIN Utilisateurs u ON n.Acteur_ID = u.ID
            WHERE n.Utilisateur_ID = $user_id
            ORDER BY n.Date_Notification DESC LIMIT 50";
    
    $res = mysqli_query($conn, $sql);
    $notifs = [];
    while($row = mysqli_fetch_assoc($res)) {
        $notifs[] = $row;
    }
    
    // 2. On les marque comme "Lues"
    mysqli_query($conn, "UPDATE Notifications SET Lu = TRUE WHERE Utilisateur_ID = $user_id AND Lu = FALSE");
    
    echo json_encode($notifs);
} else {
    echo json_encode(["erreur" => "Utilisateur non connecté"]);
}
mysqli_close($conn);
?>