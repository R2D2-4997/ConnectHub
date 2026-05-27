<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->auteur_id) && isset($data->titre) && isset($data->contenu)) {
    $c_id = (int)$data->communaute_id;
    $auteur_id = (int)$data->auteur_id;
    $titre = mysqli_real_escape_string($conn, $data->titre);
    $contenu = mysqli_real_escape_string($conn, $data->contenu);

    // DOUBLE SÉCURITÉ : On vérifie côté serveur que l'utilisateur est bien un membre accepté
    $check_droit = mysqli_query($conn, "SELECT Statut FROM membres_communautes WHERE Utilisateur_ID = $auteur_id AND Communaute_ID = $c_id AND Statut = 'Accepte'");
    
    if (mysqli_num_rows($check_droit) > 0) {
        // Le membre est autorisé, on insère la discussion
        $sql = "INSERT INTO discussions_communaute (Communaute_ID, Auteur_ID, Titre, Contenu, Score) 
                VALUES ($c_id, $auteur_id, '$titre', '$contenu', 0)";
                
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["succes" => "Votre discussion a été publiée !"]);
        } else {
            echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(["erreur" => "Action rejetée. Vous devez être un membre approuvé de cette communauté pour publier."]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>