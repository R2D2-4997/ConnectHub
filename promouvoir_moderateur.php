<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->cible_id) && isset($data->moderateur_id)) {
    $c_id = (int)$data->communaute_id;
    $cible_id = (int)$data->cible_id;
    $modo_id = (int)$data->moderateur_id;

    // Vérification de sécurité : le demandeur est-il modérateur ?
    $checkModo = mysqli_query($conn, "SELECT Role_Communaute FROM membres_communautes WHERE Utilisateur_ID = $modo_id AND Communaute_ID = $c_id AND Role_Communaute = 'Moderateur'");
    
    if (mysqli_num_rows($checkModo) > 0) {
        // Promotion du membre ciblé
        $update = mysqli_query($conn, "UPDATE membres_communautes SET Role_Communaute = 'Moderateur' WHERE Utilisateur_ID = $cible_id AND Communaute_ID = $c_id");
        if ($update) {
            echo json_encode(["succes" => "Le membre a été promu Modérateur avec succès !"]);
        } else {
            echo json_encode(["erreur" => "Erreur lors de la promotion."]);
        }
    } else {
        echo json_encode(["erreur" => "Action non autorisée. Vous n'êtes pas modérateur de ce groupe."]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>