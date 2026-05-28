<?php
require_once("config.php");

$auteur_id = isset($_POST['auteur_id']) ? (int)$_POST['auteur_id'] : 0;
$contenu = isset($_POST['contenu']) ? mysqli_real_escape_string($conn, $_POST['contenu']) : '';

$media_url = "NULL"; // Par défaut, pas de média

// 1. Vérifier si un fichier a été envoyé et s'il y a une erreur
if (isset($_FILES['media'])) {
    $erreur_upload = $_FILES['media']['error'];
    
    // Si l'upload s'est bien passé (Code 0)
    if ($erreur_upload === UPLOAD_ERR_OK) {
        $dossier_destination = 'uploads/';
        
        if (!is_dir($dossier_destination)) {
            mkdir($dossier_destination, 0777, true);
        }

        $extension = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);
        $nom_fichier = uniqid("media_") . "." . strtolower($extension);
        $chemin_final = $dossier_destination . $nom_fichier;

        if (move_uploaded_file($_FILES['media']['tmp_name'], $chemin_final)) {
            $media_url = "'" . mysqli_real_escape_string($conn, $chemin_final) . "'";
        } else {
            echo json_encode(["erreur" => "Impossible de déplacer le fichier dans le dossier uploads."]);
            exit;
        }
    } 
    // S'il y a une erreur, on la renvoie à React pour l'afficher
    else if ($erreur_upload !== UPLOAD_ERR_NO_FILE) {
        $messages_erreur = [
            UPLOAD_ERR_INI_SIZE   => "Le fichier dépasse la limite de poids (upload_max_filesize) autorisée par PHP.",
            UPLOAD_ERR_FORM_SIZE  => "Le fichier dépasse la limite de poids autorisée par le formulaire.",
            UPLOAD_ERR_PARTIAL    => "L'envoi a été interrompu, fichier incomplet.",
            UPLOAD_ERR_NO_TMP_DIR => "Il manque un dossier temporaire sur le serveur.",
            UPLOAD_ERR_CANT_WRITE => "Impossible d'écrire le fichier sur le disque.",
            UPLOAD_ERR_EXTENSION  => "Une extension PHP a bloqué l'upload."
        ];
        $msg = isset($messages_erreur[$erreur_upload]) ? $messages_erreur[$erreur_upload] : "Erreur inconnue code $erreur_upload.";
        echo json_encode(["erreur" => "Problème d'upload : " . $msg]);
        exit;
    }
}

// 2. Insérer dans la base de données
$sql = "INSERT INTO publications (Auteur_ID, Contenu, Media_URL, Date_Publication) 
        VALUES ($auteur_id, '$contenu', $media_url, NOW())";

if (mysqli_query($conn, $sql)) {
    echo json_encode(["succes" => "Publication ajoutée"]);
} else {
    echo json_encode(["erreur" => "Erreur BDD : " . mysqli_error($conn)]);
}

mysqli_close($conn);
?>