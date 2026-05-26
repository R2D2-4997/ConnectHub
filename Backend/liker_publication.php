<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->utilisateur_id)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->utilisateur_id;

    // On vérifie si l'utilisateur a déjà liké ce post
    $check = mysqli_query($conn, "SELECT * FROM likes WHERE Publication_ID = $pub_id AND Utilisateur_ID = $user_id");

    if (mysqli_num_rows($check) > 0) {
        // S'il a déjà liké, on retire le like (Toggle)
        mysqli_query($conn, "DELETE FROM likes WHERE Publication_ID = $pub_id AND Utilisateur_ID = $user_id");
        echo json_encode(["succes" => "Like retiré"]);
    } else {
        // Sinon, on ajoute le like
        mysqli_query($conn, "INSERT INTO likes (Publication_ID, Utilisateur_ID) VALUES ($pub_id, $user_id)");
        
        // --- GÉNÉRATION DE LA NOTIFICATION ---
        // On cherche à qui appartient la publication
        $resAuteur = mysqli_query($conn, "SELECT Auteur_ID FROM publications WHERE ID = $pub_id");
        if ($row = mysqli_fetch_assoc($resAuteur)) {
            $auteur_id = $row['Auteur_ID'];
            
            // On ne se notifie pas soi-même
            if ($auteur_id != $user_id) {
                $sqlNotif = "INSERT INTO notifications (Utilisateur_ID, Acteur_ID, Type_Action, Cible_ID) 
                             VALUES ($auteur_id, $user_id, 'Like', $pub_id)";
                mysqli_query($conn, $sqlNotif);
            }
        }
        
        echo json_encode(["succes" => "Like ajouté"]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes"]);
}
mysqli_close($conn);
?>