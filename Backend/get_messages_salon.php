<?php
require_once("config.php");
mysqli_set_charset($conn, "utf8mb4");

$data = json_decode(file_get_contents("php://input"));
$salon_id = isset($data->salon_id) ? (int)$data->salon_id : 0;

$sql = "SELECT m.ID, m.Expediteur_ID, m.Contenu, m.Date_Envoi, u.Nom AS Expediteur_Nom
        FROM messages_salons m
        JOIN utilisateurs u ON m.Expediteur_ID = u.ID
        WHERE m.Salon_ID = $salon_id
        ORDER BY m.Date_Envoi ASC";
        
$result = mysqli_query($conn, $sql);
$messages = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = $row;
    }
    echo json_encode($messages);
} else {
    echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
}
?>