<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->email) && isset($data->motDePasse)) {
    // Sécurisation de l'email
    $email = mysqli_real_escape_string($conn, htmlspecialchars($data->email));
    $motDePasseSaisi = $data->motDePasse;

    // Recherche de l'utilisateur par son email
    $sql = "SELECT ID, Nom, Email, MotDePasse, Role FROM Utilisateurs WHERE Email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Vérification du mot de passe haché
        if (password_verify($motDePasseSaisi, $user['MotDePasse'])) {
            // Par sécurité, on retire le mot de passe avant d'envoyer les données à React
            unset($user['MotDePasse']);
            
            echo json_encode(["succes" => true, "utilisateur" => $user]);
        } else {
            echo json_encode(["erreur" => "Mot de passe incorrect."]);
        }
    } else {
        echo json_encode(["erreur" => "Aucun compte n'est associé à cet email."]);
    }
} else {
    echo json_encode(["erreur" => "Veuillez remplir tous les champs."]);
}

mysqli_close($conn);
?>