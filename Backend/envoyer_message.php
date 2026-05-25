<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->expediteur_id) && isset($data->destinataire_id) && isset($data->contenu)) {
    $exp = (int) $data->expediteur_id;
    $dest = (int) $data->destinataire_id;
    $contenu = mysqli_real_escape_string($conn, htmlspecialchars($data->contenu));

    $sql = "INSERT INTO Messages_Prives (Expediteur_ID, Destinataire_ID, Contenu) 
            VALUES ($exp, $dest, '$contenu')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Message envoyé"]);
    } else {
        echo json_encode(["erreur" => "Erreur d'envoi : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Données incomplètes."]);
}
mysqli_close($conn);
?>