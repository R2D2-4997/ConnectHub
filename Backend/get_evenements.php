<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Requête adaptée : tables au pluriel et suppression du Createur_ID qui n'existe pas dans votre MCD
$sql = "SELECT ID, Titre, Description, Lieu, Date_evenement, 
        DATE_FORMAT(Date_evenement, '%d/%m/%Y %H:%i') AS Date_Formatee,
        'La Communauté' AS Createur,
        (SELECT COUNT(*) FROM participants_evenements WHERE Evenement_ID = evenements.ID) AS NbParticipants,
        (SELECT COUNT(*) FROM participants_evenements WHERE Evenement_ID = evenements.ID AND Utilisateur_ID = $user_id) AS EstInscrit
        FROM evenements
        ORDER BY Date_evenement ASC";

$result = mysqli_query($conn, $sql);
$evenements = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // EstInscrit devient un booléen (true/false) pour React
        $row['EstInscrit'] = ($row['EstInscrit'] > 0); 
        $evenements[] = $row;
    }
    echo json_encode($evenements);
} else {
    echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
}
mysqli_close($conn);
?>