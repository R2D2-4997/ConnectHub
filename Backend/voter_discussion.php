<?php
require_once("config.php");

// Récupération des données envoyées par React (format JSON)
$data = json_decode(file_get_contents("php://input"));

if (isset($data->discussion_id) && isset($data->utilisateur_id) && isset($data->valeur)) {
    $discussion_id = (int)$data->discussion_id;
    $utilisateur_id = (int)$data->utilisateur_id;
    $valeur = (int)$data->valeur;

    if ($valeur === 0) {
        // Valeur = 0 : L'utilisateur annule son vote
        $query = "DELETE FROM votes_discussions 
                  WHERE Discussion_ID = $discussion_id AND Utilisateur_ID = $utilisateur_id";
        mysqli_query($conn, $query);
    } else {
        // Valeur = 1 ou -1 : On insère le vote. 
        // S'il existe déjà (grâce à notre clé UNIQUE), on le met à jour.
        $query = "INSERT INTO votes_discussions (Discussion_ID, Utilisateur_ID, Valeur) 
                  VALUES ($discussion_id, $utilisateur_id, $valeur) 
                  ON DUPLICATE KEY UPDATE Valeur = $valeur";
        mysqli_query($conn, $query);
    }

    // --- RECALCUL DU SCORE TOTAL ---
    // On additionne tous les +1 et -1 pour cette discussion et on met à jour la table principale
    $updateScoreQuery = "UPDATE discussions 
                         SET Score = (SELECT COALESCE(SUM(Valeur), 0) FROM votes_discussions WHERE Discussion_ID = $discussion_id) 
                         WHERE ID = $discussion_id";
    mysqli_query($conn, $updateScoreQuery);

    echo json_encode(["succes" => "Vote enregistré et score mis à jour."]);

} else {
    echo json_encode(["erreur" => "Données de vote incomplètes."]);
}

mysqli_close($conn);
?>