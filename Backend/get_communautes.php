<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

// Utilisation d'un CASE WHEN : si le rôle est 'Moderateur', le statut membre passe à 'Accepte' par défaut
$sql = "SELECT c.ID, c.Nom, c.Description, 
        (SELECT COUNT(*) FROM membres_communautes WHERE Communaute_ID = c.ID AND Statut = 'Accepte') AS NbMembres,
        CASE WHEN mc.Role_Communaute = 'Moderateur' THEN 'Accepte' ELSE mc.Statut END AS Statut_Membre, 
        mc.Role_Communaute
        FROM communautes c
        LEFT JOIN membres_communautes mc ON c.ID = mc.Communaute_ID AND mc.Utilisateur_ID = $user_id
        ORDER BY NbMembres DESC";

$result = mysqli_query($conn, $sql);
$communautes = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { 
        $communautes[] = $row; 
    }
    echo json_encode($communautes);
} else {
    echo json_encode(["erreur" => mysqli_error($conn)]);
}
mysqli_close($conn);
?>