<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->evenement_id) && isset($data->utilisateur_id)) {
    $evt_id = (int)$data->evenement_id;
    $user_id = (int)$data->utilisateur_id;

    // On vérifie si l'utilisateur participe déjà (Attention au nom de la table pluriel)
    $check = mysqli_query($conn, "SELECT * FROM participants_evenements WHERE Evenement_ID = $evt_id AND Utilisateur_ID = $user_id");

    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["info" => "Vous êtes déjà inscrit à cet événement."]);
    } else {
        // Sinon, on l'inscrit !
        $insert = mysqli_query($conn, "INSERT INTO participants_evenements (Evenement_ID, Utilisateur_ID) VALUES ($evt_id, $user_id)");
        
        if ($insert) {
            echo json_encode(["succes" => "Inscription confirmée !"]);
        } else {
            echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
        }
    }
} else {
    echo json_encode(["erreur" => "Données manquantes"]);
}
mysqli_close($conn);
?>