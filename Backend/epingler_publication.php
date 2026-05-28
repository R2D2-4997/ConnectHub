<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->utilisateur_id)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->utilisateur_id;

    // Vérifie l'état actuel de la publication (et s'assure que c'est bien l'auteur qui modifie)
    $check = mysqli_query($conn, "SELECT Est_Epingle FROM publications WHERE ID = $pub_id AND Auteur_ID = $user_id");
    
    if ($row = mysqli_fetch_assoc($check)) {
        // Inverse le statut : si 1 devient 0, si 0 devient 1
        $nouvel_etat = $row['Est_Epingle'] ? 0 : 1;
        mysqli_query($conn, "UPDATE publications SET Est_Epingle = $nouvel_etat WHERE ID = $pub_id");
        echo json_encode(["succes" => "Statut mis à jour", "est_epingle" => $nouvel_etat]);
    } else {
        echo json_encode(["erreur" => "Publication introuvable ou non autorisée."]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>