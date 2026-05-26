<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

if ($user_id > 0) {
    // 1. On récupère les notifications avec le nom de l'acteur
    $sql = "SELECT n.ID, n.Type_Action, n.Lu, n.Date_Notification, u.Nom AS ActeurNom 
            FROM notifications n
            JOIN utilisateurs u ON n.Acteur_ID = u.ID
            WHERE n.Utilisateur_ID = $user_id
            ORDER BY n.Date_Notification DESC LIMIT 50";
            
    $result = mysqli_query($conn, $sql);
    $notifs = [];
    
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $notifs[] = $row;
        }
        
        // 2. On marque les notifications comme lues (Lu = 1)
        mysqli_query($conn, "UPDATE notifications SET Lu = 1 WHERE Utilisateur_ID = $user_id AND Lu = 0");
        
        echo json_encode($notifs);
    } else {
        echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Utilisateur non connecté"]);
}
mysqli_close($conn);
?>