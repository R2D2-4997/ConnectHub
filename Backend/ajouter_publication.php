<?php
require_once("config.php");

// Avec des fichiers (FormData), on utilise $_POST et $_FILES, plus json_decode
$contenu = isset($_POST['contenu']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['contenu'])) : '';
$auteur_id = isset($_POST['auteur_id']) ? (int)$_POST['auteur_id'] : 0;

if ($auteur_id > 0 && ($contenu !== '' || isset($_FILES['media']))) {
    $media_url = NULL;

    // Gestion du fichier s'il y en a un
    if (isset($_FILES['media']) && $_FILES['media']['error'] === UPLOAD_ERR_OK) {
        $dossier_cible = "uploads/";
        
        // Crée le dossier s'il n'existe pas déjà
        if (!is_dir($dossier_cible)) {
            mkdir($dossier_cible, 0777, true);
        }

        $nom_fichier = basename($_FILES["media"]["name"]);
        // On ajoute un timestamp au nom pour éviter que deux fichiers s'écrasent s'ils ont le même nom
        $nom_fichier_propre = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $nom_fichier);
        $chemin_cible = $dossier_cible . $nom_fichier_propre;

        $type_fichier = strtolower(pathinfo($chemin_cible, PATHINFO_EXTENSION));
        // On limite aux formats classiques d'images et vidéos
        $extensions_valides = array("jpg", "jpeg", "png", "gif", "mp4", "webm");

        if (in_array($type_fichier, $extensions_valides)) {
            if (move_uploaded_file($_FILES["media"]["tmp_name"], $chemin_cible)) {
                $media_url = $chemin_cible; // On sauvegarde le chemin relatif
            }
        }
    }

    // Insertion en base de données
    $sql = "INSERT INTO Publications (Auteur_ID, Contenu, Media_URL) 
            VALUES ($auteur_id, '$contenu', " . ($media_url ? "'$media_url'" : "NULL") . ")";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Publication partagée avec succès !"]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de la publication : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Message vide ou utilisateur non identifié."]);
}

mysqli_close($conn);
?>