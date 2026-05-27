<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->salon_id) && isset($data->expediteur_id) && !empty($data->contenu)) {
    $s_id = (int)$data->salon_id;
    $exp_id = (int)$data->expediteur_id;
    $contenu = mysqli_real_escape_string($conn, $data->contenu);

    mysqli_query($conn, "INSERT INTO messages_salons (Salon_ID, Expediteur_ID, Contenu) VALUES ($s_id, $exp_id, '$contenu')");
    echo json_encode(["succes" => "Message envoyé"]);
}
mysqli_close($conn);
?>