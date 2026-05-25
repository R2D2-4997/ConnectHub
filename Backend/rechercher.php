<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->requete) && isset($data->type)) {
    // Sécurisation du mot clé
    $mot_cle = mysqli_real_escape_string($conn, htmlspecialchars($data->requete));
    $type = $data->type;
    $resultats = [];

    // On ne cherche que si la barre n'est pas vide
    if (!empty($mot_cle)) {
        
        if ($type === 'publications') {
            // Cherche dans le contenu des posts
            $sql = "SELECT p.ID, p.Contenu, p.Date_Publication, u.Nom 
                    FROM Publications p 
                    JOIN Utilisateurs u ON p.Auteur_ID = u.ID 
                    WHERE p.Contenu LIKE '%$mot_cle%' 
                    ORDER BY p.Date_Publication DESC";
            
        } elseif ($type === 'utilisateurs') {
            // Cherche un athlète par son nom
            $sql = "SELECT ID, Nom, Role FROM Utilisateurs WHERE Nom LIKE '%$mot_cle%'";
            
        } elseif ($type === 'communautes') {
            // Cherche un groupe par son nom ou sa description
            $sql = "SELECT ID, Nom, Description FROM Communautes WHERE Nom LIKE '%$mot_cle%' OR Description LIKE '%$mot_cle%'";
        }

        // Exécution de la requête si elle a été définie (donc pas pour événements/sports pour l'instant)
        if (isset($sql)) {
            $res = mysqli_query($conn, $sql);
            if ($res) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $resultats[] = $row;
                }
            }
        }
    }
    
    echo json_encode($resultats);

} else {
    echo json_encode(["erreur" => "Paramètres de recherche manquants."]);
}

mysqli_close($conn);
?>