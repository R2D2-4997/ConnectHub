<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->cible_id) && isset($data->signaleur_id) && isset($data->motif)) {
    $cible_id = (int)$data->cible_id;
    $user_id = (int)$data->signaleur_id;
    $motif = mysqli_real_escape_string($conn, $data->motif);

    // On insère l'ID de la cible et on laisse Publication_ID vide (NULL par défaut)
    $insert = mysqli_query($conn, "INSERT INTO signalements (Utilisateur_Cible_ID, Signaleur_ID, Motif) VALUES ($cible_id, $user_id, '$motif')");

    if ($insert) {
        // Envoi d'une notification aux modérateurs
        $resModos = mysqli_query($conn, "SELECT ID FROM utilisateurs WHERE Role = 'Moderateur'");
        while ($modo = mysqli_fetch_assoc($resModos)) {
            $modo_id = $modo['ID'];
            mysqli_query($conn, "INSERT INTO notifications (Utilisateur_ID, Acteur_ID, Type_Action, Cible_ID) 
                         VALUES ($modo_id, $user_id, 'Signalement', $cible_id)");
        }
        
        echo json_encode(["succes" => "Le profil a été signalé à l'équipe de modération."]);
    } else {
        echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes"]);
}
mysqli_close($conn);
?>