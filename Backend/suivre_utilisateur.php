<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->suiveur_id) && isset($data->suivi_id)) {
    $suiveur = (int)$data->suiveur_id;
    $suivi = (int)$data->suivi_id;

    if ($suiveur === $suivi) {
        echo json_encode(["erreur" => "Vous ne pouvez pas vous abonner à vous-même."]);
        exit;
    }

    // Vérifier si l'abonnement existe déjà
    $check = mysqli_query($conn, "SELECT * FROM Abonnements WHERE Suiveur_ID = $suiveur AND Suivi_ID = $suivi");

    if (mysqli_num_rows($check) > 0) {
        // Déjà abonnée -> Désabonnement
        mysqli_query($conn, "DELETE FROM Abonnements WHERE Suiveur_ID = $suiveur AND Suivi_ID = $suivi");
        echo json_encode(["succes" => "Désabonné avec succès !", "action" => "unfollow"]);
    } else {
        // Pas encore abonné -> Abonnement
        mysqli_query($conn, "INSERT INTO Abonnements (Suiveur_ID, Suivi_ID) VALUES ($suiveur, $suivi)");
        echo json_encode(["succes" => "Abonné avec succès !", "action" => "follow"]);
    }
}
mysqli_close($conn);
?>