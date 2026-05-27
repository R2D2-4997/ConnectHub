<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->demandeur_id) && isset($data->moderateur_id) && isset($data->action)) {
    $c_id = (int)$data->communaute_id;
    $demandeur_id = (int)$data->demandeur_id;
    $modo_id = (int)$data->moderateur_id;
    $action = $data->action; 

    // Vérification de sécurité : le modérateur est-il bien modérateur local ?
    $checkModo = mysqli_query($conn, "SELECT Role_Communaute FROM membres_communautes WHERE Utilisateur_ID = $modo_id AND Communaute_ID = $c_id AND Role_Communaute = 'Moderateur'");
    
    if (mysqli_num_rows($checkModo) > 0) {
        if ($action === 'accepter') {
            mysqli_query($conn, "UPDATE membres_communautes SET Statut = 'Accepte' WHERE Utilisateur_ID = $demandeur_id AND Communaute_ID = $c_id");
            echo json_encode(["succes" => "Le membre a été accepté !"]);
        } else if ($action === 'rejeter') {
            // Rejeter supprime la demande de la table
            mysqli_query($conn, "DELETE FROM membres_communautes WHERE Utilisateur_ID = $demandeur_id AND Communaute_ID = $c_id");
            echo json_encode(["succes" => "La demande a été rejetée."]);
        }
    } else {
        echo json_encode(["erreur" => "Action non autorisée. Vous n'êtes pas modérateur de ce groupe."]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>