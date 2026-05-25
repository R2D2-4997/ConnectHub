<?php
require_once("config.php");

$sql = "SELECT ID, Nom, Email, Role FROM Utilisateurs ORDER BY Nom ASC";
$result = mysqli_query($conn, $sql);

$utilisateurs = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $utilisateurs[] = $row;
    }
    echo json_encode($utilisateurs);
} else {
    echo json_encode(["erreur" => "Erreur lors de la récupération des contacts : " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>