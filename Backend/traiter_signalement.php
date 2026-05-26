<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->signalement_id) && isset($data->action) && isset($data->moderateur_id)) {
    $sig_id = (int)$data->signalement_id;
    $pub_id = (int)$data->publication_id;
    $action = $data->action; // 'supprimer' ou 'rejeter'
    $mod_id = (int)$data->moderateur_id;

    // Vérification du rôle
    $check = mysqli_query($conn, "SELECT Role FROM Utilisateurs WHERE ID = $mod_id");
    $user = mysqli_fetch_assoc($check);

    if ($user && $user['Role'] === 'Moderateur') {
        if ($action === 'supprimer') {
            // Supprimer le post supprime automatiquement le signalement lié grâce au ON DELETE CASCADE
            mysqli_query($conn, "DELETE FROM Publications WHERE ID = $pub_id");
            echo json_encode(["succes" => "La publication a été supprimée définitivement."]);
        } else {
            // On rejette le signalement, le post reste en ligne
            mysqli_query($conn, "UPDATE Signalements SET Statut = 'Rejete' WHERE ID = $sig_id");
            echo json_encode(["succes" => "Signalement rejeté."]);
        }
    } else {
        echo json_encode(["erreur" => "Action non autorisée."]);
    }
}
mysqli_close($conn);
?>