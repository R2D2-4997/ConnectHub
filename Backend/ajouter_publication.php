<?php
require_once("config.php");
mysqli_set_charset($conn, "utf8mb4");

$data = !empty($_POST) ? (object)$_POST : json_decode(file_get_contents("php://input"));

if (isset($data->auteur_id) && isset($data->contenu)) {
    $auteur_id = (int)$data->auteur_id;
    $contenu = mysqli_real_escape_string($conn, $data->contenu);
    
    // NOUVEAUTÉ : Vérification Anti-Doublon
    $check_sql = "SELECT ID FROM publications WHERE Auteur_ID = $auteur_id AND Contenu = '$contenu' LIMIT 1";
    $check_res = mysqli_query($conn, $check_sql);
    if(mysqli_num_rows($check_res) > 0) {
         echo json_encode(["erreur" => "Vous avez déjà publié exactement ce même message."]);
         exit;
    }

    $mediaUrl = "";
    // ... (Gardez le reste de votre logique d'upload de fichier media ici) ...
    
    $sql = "INSERT INTO publications (Auteur_ID, Contenu, Media_URL) VALUES ($auteur_id, '$contenu', '$mediaUrl')";
    if (mysqli_query($conn, $sql)) echo json_encode(["succes" => "Publication ajoutée"]);
    else echo json_encode(["erreur" => mysqli_error($conn)]);
}
?>