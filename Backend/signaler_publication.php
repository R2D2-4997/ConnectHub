<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->publication_id) && isset($data->signaleur_id) && isset($data->motif)) {
    $pub_id = (int)$data->publication_id;
    $user_id = (int)$data->signaleur_id;
    $motif = mysqli_real_escape_string($conn, $data->motif);

    $insert = mysqli_query($conn, "INSERT INTO signalements (Publication_ID, Signaleur_ID, Motif) VALUES ($pub_id, $user_id, '$motif')");

    if ($insert) {
        // --- GÉNÉRATION DES NOTIFICATIONS POUR LES MODÉRATEURS ---
        $resModos = mysqli_query($conn, "SELECT ID FROM utilisateurs WHERE Role = 'Moderateur'");
        while ($modo = mysqli_fetch_assoc($resModos)) {
            $modo_id = $modo['ID'];
            mysqli_query($conn, "INSERT INTO notifications (Utilisateur_ID, Acteur_ID, Type_Action, Cible_ID) 
                         VALUES ($modo_id, $user_id, 'Signalement', $pub_id)");
        }
        
        echo json_encode(["succes" => "Signalement envoyé à l'équipe de modération."]);
    } else {
        echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes"]);
}
mysqli_close($conn);
?>