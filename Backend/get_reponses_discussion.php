<?php
require_once("config.php");
$discId = isset($_GET['discussion_id']) ? (int)$_GET['discussion_id'] : 0;
$result = mysqli_query($conn, "SELECT c.ID, c.Contenu, DATE_FORMAT(c.Date_Commentaire, '%d/%m/%Y %H:%i') as Date_Reponse, u.Nom FROM commentaires c JOIN utilisateurs u ON c.Auteur_ID = u.ID WHERE c.Publication_ID = $discId ORDER BY c.Date_Commentaire ASC");
$reponses = [];
while ($row = mysqli_fetch_assoc($result)) { $reponses[] = $row; }
echo json_encode($reponses);
?>