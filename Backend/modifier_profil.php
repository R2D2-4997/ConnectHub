<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id) && isset($data->nom) && isset($data->email)) {
    
    $id = (int) $data->id;
    $nom = mysqli_real_escape_string($conn, htmlspecialchars($data->nom));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($data->email));
    $nouveau_mdp = isset($data->motDePasse) ? $data->motDePasse : '';

    // 1. Vérifier que le nouvel email n'est pas déjà pris par un autre utilisateur
    $check_sql = "SELECT ID FROM Utilisateurs WHERE Email = '$email' AND ID != $id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo json_encode(["erreur" => "Cette adresse email est déjà utilisée par un autre compte."]);
        exit;
    }

    // 2. Préparer la requête de mise à jour
    if (!empty($nouveau_mdp)) {
        // L'utilisateur veut changer son mot de passe
        $motDePasseHache = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
        $sql = "UPDATE Utilisateurs SET Nom='$nom', Email='$email', MotDePasse='$motDePasseHache' WHERE ID=$id";
    } else {
        // L'utilisateur ne change que son nom et/ou email
        $sql = "UPDATE Utilisateurs SET Nom='$nom', Email='$email' WHERE ID=$id";
    }

    // 3. Exécuter la mise à jour
    if (mysqli_query($conn, $sql)) {
        // Récupérer les nouvelles informations pour mettre à jour l'interface React
        $sql_get = "SELECT ID, Nom, Email, Role FROM Utilisateurs WHERE ID = $id";
        $res_get = mysqli_query($conn, $sql_get);
        $user = mysqli_fetch_assoc($res_get);
        
        echo json_encode(["succes" => "Vos informations ont été mises à jour.", "utilisateur" => $user]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de la mise à jour : " . mysqli_error($conn)]);
    }

} else {
    echo json_encode(["erreur" => "Données manquantes."]);
}

mysqli_close($conn);
?>