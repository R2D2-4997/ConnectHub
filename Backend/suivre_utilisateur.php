<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->suiveur_id) && isset($data->suivi_id)) {
    $suiveur = (int)$data->suiveur_id;
    $suivi = (int)$data->suivi_id;

    if ($suiveur === $suivi) { echo json_encode(["erreur" => "Action impossible."]); exit; }

    $check = mysqli_query($conn, "SELECT * FROM Abonnements WHERE Suiveur_ID = $suiveur AND Suivi_ID = $suivi");

    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM Abonnements WHERE Suiveur_ID = $suiveur AND Suivi_ID = $suivi");
        echo json_encode(["succes" => "Désabonné avec succès !"]);
    } else {
        mysqli_query($conn, "INSERT INTO Abonnements (Suiveur_ID, Suivi_ID) VALUES ($suiveur, $suivi)");
        
        // --- GÉNÉRATION DE LA NOTIFICATION ---
        mysqli_query($conn, "INSERT INTO Notifications (Utilisateur_ID, Acteur_ID, Type_Action) 
                             VALUES ($suivi, $suiveur, 'Abonnement')");
                             
        echo json_encode(["succes" => "Abonné avec succès !"]);
    }
}
mysqli_close($conn);
?>