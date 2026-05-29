<?php
require_once("config.php");
mysqli_set_charset($conn, "utf8mb4"); // FIX CARACTÈRES SPÉCIAUX

$data = json_decode(file_get_contents("php://input"));
if (isset($data->expediteur_id) && isset($data->salon_id) && isset($data->contenu)) {
    $exp = (int)$data->expediteur_id;
    $salon = (int)$data->salon_id;
    // Indispensable pour que les accents, apostrophes et émojis n'annulent pas l'envoi
    $contenu = mysqli_real_escape_string($conn, $data->contenu); 
    
    $sql = "INSERT INTO messages_salons (Salon_ID, Expediteur_ID, Contenu) VALUES ($salon, $exp, '$contenu')";
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Message envoyé"]);
    } else {
        echo json_encode(["erreur" => mysqli_error($conn)]);
    }
}
?>