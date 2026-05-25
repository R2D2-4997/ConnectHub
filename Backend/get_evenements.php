<?php
require_once("config.php");

$sql = "SELECT e.ID, e.Titre, e.Description, e.Date_Evenement, e.Lieu, u.Nom AS Createur,
        (SELECT COUNT(*) FROM Participants_Evenements WHERE Evenement_ID = e.ID) AS NbParticipants
        FROM Evenements e
        JOIN Utilisateurs u ON e.Createur_ID = u.ID
        WHERE e.Date_Evenement >= CURDATE()
        ORDER BY e.Date_Evenement ASC";

$result = mysqli_query($conn, $sql);
$evenements = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // On formate un peu la date en PHP pour qu'elle soit plus jolie pour React
        $date = new DateTime($row['Date_Evenement']);
        $row['Date_Formatee'] = $date->format('d/m/Y à H:i');
        $evenements[] = $row;
    }
    echo json_encode($evenements);
} else {
    echo json_encode(["erreur" => "Erreur de chargement : " . mysqli_error($conn)]);
}
mysqli_close($conn);
?>