<?php
require_once("config.php");
mysqli_set_charset($conn, "utf8mb4");

$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$sql = "SELECT sp.ID, sp.Nom 
        FROM salons_prives sp 
        JOIN membres_salons ms ON sp.ID = ms.Salon_ID 
        WHERE ms.Utilisateur_ID = $user_id";
        
$result = mysqli_query($conn, $sql);
$salons = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $salons[] = $row;
    }
}
echo json_encode($salons);
?>