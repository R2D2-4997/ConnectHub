<?php
require_once("config.php");

// React enverra désormais un objet FormData, on utilise donc $_POST et $_FILES
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mdp = isset($_POST['motDePasse']) ? $_POST['motDePasse'] : '';

    $sql = "UPDATE utilisateurs SET Nom='$nom', Email='$email'";
    if (!empty($mdp)) {
        $sql .= ", MotDePasse='$mdp'"; 
    }
    $sql .= " WHERE ID=$id";
    mysqli_query($conn, $sql);

    // --- SAUVEGARDE DE LA PHOTO DE PROFIL ---
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        if (!is_dir('uploads')) { mkdir('uploads', 0777, true); } // Crée le dossier s'il manque
        
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $filename = "uploads/avatar_" . $id . "_" . time() . "." . $ext;
        
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filename)) {
            mysqli_query($conn, "UPDATE utilisateurs SET Photo_Profil='$filename' WHERE ID=$id");
        }
    }

    // On renvoie l'utilisateur mis à jour pour rafraîchir React
    $res = mysqli_query($conn, "SELECT ID, Nom, Email, Role, Photo_Profil FROM utilisateurs WHERE ID=$id");
    $user = mysqli_fetch_assoc($res);
    
    echo json_encode(["succes" => "Profil mis à jour !", "utilisateur" => $user]);
} else {
    echo json_encode(["erreur" => "ID manquant"]);
}
mysqli_close($conn);
?>