<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->expediteur_id) && isset($data->destinataire_id) && isset($data->contenu)) {
    $exp = (int) $data->expediteur_id;
    $dest = (int) $data->destinataire_id;
    $contenu = mysqli_real_escape_string($conn, htmlspecialchars($data->contenu));

    // Vérification du suivi mutuel
    $mutual_check = mysqli_query($conn, "
        SELECT 
            (SELECT COUNT(*) FROM Abonnements WHERE Suiveur_ID = $exp AND Suivi_ID = $dest) as suit_dest,
            (SELECT COUNT(*) FROM Abonnements WHERE Suiveur_ID = $dest AND Suivi_ID = $exp) as suit_exp
    ");
    $row = mysqli_fetch_assoc($mutual_check);
    
    // Si les deux s'abonnent l'un à l'autre -> Accepté, sinon -> En attente (Demande)
    $statut = ($row['suit_dest'] > 0 && $row['suit_exp'] > 0) ? 'Accepte' : 'En_Attente';

    $sql = "INSERT INTO Messages_Prives (Expediteur_ID, Destinataire_ID, Contenu, Statut) 
            VALUES ($exp, $dest, '$contenu', '$statut')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Message traité", "statut" => $statut]);
    } else {
        echo json_encode(["erreur" => mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>