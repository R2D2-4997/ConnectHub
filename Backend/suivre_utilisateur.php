<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->suiveur_id) && isset($data->suivi_id)) {
    $suiveur = (int)$data->suiveur_id; // Celui qui clique
    $suivi = (int)$data->suivi_id;     // Celui qui est suivi

    if ($suiveur === $suivi) { 
        echo json_encode(["erreur" => "Vous ne pouvez pas vous suivre vous-même."]); 
        exit; 
    }

    // On vérifie si l'abonnement existe déjà
    $check = mysqli_query($conn, "SELECT * FROM abonnements WHERE Suiveur_ID = $suiveur AND Suivi_ID = $suivi");

    if (mysqli_num_rows($check) > 0) {
        // S'il existe, on désabonne
        mysqli_query($conn, "DELETE FROM abonnements WHERE Suiveur_ID = $suiveur AND Suivi_ID = $suivi");
        echo json_encode(["succes" => "Désabonné avec succès !"]);
    } else {
        // Sinon, on abonne
        mysqli_query($conn, "INSERT INTO abonnements (Suiveur_ID, Suivi_ID) VALUES ($suiveur, $suivi)");
        
        // --- GÉNÉRATION DE LA NOTIFICATION ---
        $sqlNotif = "INSERT INTO notifications (Utilisateur_ID, Acteur_ID, Type_Action) 
                     VALUES ($suivi, $suiveur, 'Abonnement')";
        mysqli_query($conn, $sqlNotif);
                             
        echo json_encode(["succes" => "Abonné avec succès !"]);
    }
} else {
    echo json_encode(["erreur" => "Données manquantes"]);
}
mysqli_close($conn);
?>