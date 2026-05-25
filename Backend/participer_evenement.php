<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->evenement_id) && isset($data->utilisateur_id)) {
    $event = (int) $data->evenement_id;
    $user = (int) $data->utilisateur_id;

    $check = mysqli_query($conn, "SELECT * FROM Participants_Evenements WHERE Evenement_ID=$event AND Utilisateur_ID=$user");

    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["info" => "Vous êtes déjà inscrit à cet événement !"]);
    } else {
        $sql = "INSERT INTO Participants_Evenements (Evenement_ID, Utilisateur_ID) VALUES ($event, $user)";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["succes" => "Votre participation est confirmée !"]);
        } else {
            echo json_encode(["erreur" => "Erreur : " . mysqli_error($conn)]);
        }
    }
}
mysqli_close($conn);
?>