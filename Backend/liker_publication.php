<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->utilisateur_id)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->utilisateur_id;

    $check = mysqli_query($conn, "SELECT * FROM Likes WHERE Publication_ID = $pub_id AND Utilisateur_ID = $user_id");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM Likes WHERE Publication_ID = $pub_id AND Utilisateur_ID = $user_id");
        echo json_encode(["succes" => "Like retiré"]);
    } else {
        mysqli_query($conn, "INSERT INTO Likes (Publication_ID, Utilisateur_ID) VALUES ($pub_id, $user_id)");
        
        // --- GÉNÉRATION DE LA NOTIFICATION ---
        $resAuteur = mysqli_query($conn, "SELECT Auteur_ID FROM Publications WHERE ID = $pub_id");
        $auteur = mysqli_fetch_assoc($resAuteur)['Auteur_ID'];
        
        // On vérifie que l'on ne s'envoie pas une notification à soi-même
        if ($auteur != $user_id) {
            mysqli_query($conn, "INSERT INTO Notifications (Utilisateur_ID, Acteur_ID, Type_Action, Cible_ID) 
                                 VALUES ($auteur, $user_id, 'Like', $pub_id)");
        }
        
        echo json_encode(["succes" => "Like ajouté"]);
    }
}
mysqli_close($conn);
?>