<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->utilisateur_id)) {
    $pub_id = (int) $data->publication_id;
    $user_id = (int) $data->utilisateur_id;

    // Logique métier : On vérifie si l'utilisateur a déjà liké cette publication
    $check_sql = "SELECT ID FROM Likes WHERE Publication_ID = $pub_id AND Utilisateur_ID = $user_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Le like existe déjà -> on l'enlève (Unlike)
        $delete_sql = "DELETE FROM Likes WHERE Publication_ID = $pub_id AND Utilisateur_ID = $user_id";
        mysqli_query($conn, $delete_sql);
        echo json_encode(["statut" => "unlike", "message" => "Like retiré"]);
    } else {
        // Le like n'existe pas -> on l'ajoute (Like)
        $insert_sql = "INSERT INTO Likes (Publication_ID, Utilisateur_ID) VALUES ($pub_id, $user_id)";
        mysqli_query($conn, $insert_sql);
        echo json_encode(["statut" => "like", "message" => "Publication likée"]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes."]);
}

mysqli_close($conn);
?>