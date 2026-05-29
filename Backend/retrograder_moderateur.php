<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->cible_id) && isset($data->moderateur_id)) {
    $communaute_id = (int)$data->communaute_id;
    $cible_id = (int)$data->cible_id;
    $moderateur_id = (int)$data->moderateur_id;

    // 1. Vérification de sécurité : compter le nombre de modérateurs actuels
    $countQuery = "SELECT COUNT(*) as nb_modos FROM membres_communautes WHERE Communaute_ID = $communaute_id AND Role_Communaute = 'Moderateur'";
    $countResult = mysqli_query($conn, $countQuery);
    $row = mysqli_fetch_assoc($countResult);
    
    if ($row['nb_modos'] <= 1) {
        echo json_encode(["erreur" => "Impossible : Il doit toujours y avoir au moins un modérateur dans ce Hub."]);
        exit;
    }

    // 2. Si on a plus de 1 modérateur, on peut rétrograder la cible
    $query = "UPDATE membres_communautes SET Role_Communaute = 'Membre' WHERE Communaute_ID = $communaute_id AND Utilisateur_ID = $cible_id";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["succes" => "L'utilisateur n'est plus modérateur."]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de la mise à jour : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes."]);
}
mysqli_close($conn);
?>