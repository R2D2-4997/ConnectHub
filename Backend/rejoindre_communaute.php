<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->utilisateur_id)) {
    $communaute_id = (int) $data->communaute_id;
    $utilisateur_id = (int) $data->utilisateur_id;

    // Logique métier : Vérifier si l'utilisateur est déjà membre du groupe
    $check_sql = "SELECT * FROM Membres_Communautes WHERE Communaute_ID = $communaute_id AND Utilisateur_ID = $utilisateur_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Déjà membre
        echo json_encode(["info" => "Vous faites déjà partie de ce groupe d'entraînement !"]);
    } else {
        // Pas encore membre, on l'ajoute
        $insert_sql = "INSERT INTO Membres_Communautes (Communaute_ID, Utilisateur_ID) VALUES ($communaute_id, $utilisateur_id)";
        
        if (mysqli_query($conn, $insert_sql)) {
            echo json_encode(["succes" => "Vous avez rejoint la communauté avec succès !"]);
        } else {
            echo json_encode(["erreur" => "Erreur lors de l'inscription : " . mysqli_error($conn)]);
        }
    }
} else {
    echo json_encode(["erreur" => "Données manquantes."]);
}

mysqli_close($conn);
?>