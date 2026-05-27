<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->utilisateur_id)) {
    $c_id = (int)$data->communaute_id;
    $u_id = (int)$data->utilisateur_id;

    $check = mysqli_query($conn, "SELECT Statut FROM membres_communautes WHERE Utilisateur_ID = $u_id AND Communaute_ID = $c_id");
    
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["info" => "Vous avez déjà interagi avec ce groupe."]);
    } else {
        $insert = mysqli_query($conn, "INSERT INTO membres_communautes (Utilisateur_ID, Communaute_ID, Role_Communaute, Statut) VALUES ($u_id, $c_id, 'Membre', 'En_Attente')");
        if ($insert) echo json_encode(["succes" => "Demande d'adhésion envoyée au modérateur !"]);
        else echo json_encode(["erreur" => "Erreur SQL : " . mysqli_error($conn)]);
    }
}
mysqli_close($conn);
?>