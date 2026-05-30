<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->communaute_id) && isset($data->utilisateur_id)) {
    $commId = (int)$data->communaute_id;
    $userId = (int)$data->utilisateur_id;

    // 1. SÉCURITÉ : Vérifier si l'utilisateur est un modérateur du Hub
    $checkSql = "SELECT Role_Communaute FROM membres_communautes WHERE Communaute_ID = $commId AND Utilisateur_ID = $userId";
    $res = mysqli_query($conn, $checkSql);
    $row = mysqli_fetch_assoc($res);

    if ($row && $row['Role_Communaute'] === 'Moderateur') {
        // S'il est modérateur, on compte combien il en reste
        $countSql = "SELECT COUNT(*) as nb FROM membres_communautes WHERE Communaute_ID = $commId AND Role_Communaute = 'Moderateur'";
        $resCount = mysqli_query($conn, $countSql);
        $rowCount = mysqli_fetch_assoc($resCount);
        
        if ($rowCount['nb'] <= 1) {
            // S'il est le dernier, on bloque le départ
            echo json_encode(["erreur" => "Action refusée : Vous êtes le dernier administrateur de ce Hub. Vous devez nommer un autre modérateur avant de quitter, ou supprimer définitivement le Hub."]);
            exit;
        }
    }

    // 2. Si tout est bon (membre normal ou s'il reste d'autres admins), on le retire
    mysqli_query($conn, "DELETE FROM membres_communautes WHERE Communaute_ID = $commId AND Utilisateur_ID = $userId");
    echo json_encode(["succes" => "Vous avez quitté le Hub avec succès."]);
} else {
    echo json_encode(["erreur" => "Données manquantes."]);
}
?>