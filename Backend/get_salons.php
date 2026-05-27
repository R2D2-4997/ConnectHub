<?php
require_once("config.php");
$user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;

$sql = "SELECT s.ID, s.Nom FROM salons_prives s 
        JOIN membres_salons ms ON s.ID = ms.Salon_ID 
        WHERE ms.Utilisateur_ID = $user_id";

$result = mysqli_query($conn, $sql);
$salons = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) { $salons[] = $row; }
}
echo json_encode($salons);
mysqli_close($conn);
?>