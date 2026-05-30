<?php
require_once("config.php");
mysqli_set_charset($conn, "utf8mb4");

$salon_id = isset($_GET['salon_id']) ? (int)$_GET['salon_id'] : 0;
// On lie la table membres_salons avec utilisateurs pour récupérer les Noms
$sql = "SELECT u.ID, u.Nom FROM membres_salons ms JOIN utilisateurs u ON ms.Utilisateur_ID = u.ID WHERE ms.Salon_ID = $salon_id";
$res = mysqli_query($conn, $sql);

$membres = [];
if($res) {
    while($row = mysqli_fetch_assoc($res)) {
        $membres[] = $row;
    }
}
echo json_encode($membres);
?>