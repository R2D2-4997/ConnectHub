<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->demandeur_id) && isset($data->moderateur_id)) {
    $c_id = (int)$data->communaute_id;
    $demandeur_id = (int)$data->demandeur_id;
    $modo_id = (int)$data->moderateur_id;

    // 1. Vérification de sécurité : le modérateur est-il bien modérateur local ?
    $checkModo = mysqli_query($conn, "SELECT Role_Communaute FROM membres_communautes WHERE Utilisateur_ID = $modo_id AND Communaute_ID = $c_id AND Role_Communaute = 'Moderateur'");
    
    if (mysqli_num_rows($checkModo) > 0) {
        // 2. On passe le statut à "Accepte"
        mysqli_query($conn, "UPDATE membres_communautes SET Statut = 'Accepte' WHERE Utilisateur_ID = $demandeur_id AND Communaute_ID = $c_id");
        echo json_encode(["succes" => "Le membre a été accepté dans la communauté !"]);
    } else {
        echo json_encode(["erreur" => "Action non autorisée. Vous n'êtes pas modérateur de ce groupe."]);
    }
}
mysqli_close($conn);
?>