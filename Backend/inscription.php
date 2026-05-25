<?php
require_once("config.php");

// Récupération des données envoyées par React en format JSON
$data = json_decode(file_get_contents("php://input"));

// Vérification que les champs requis sont présents
if (isset($data->nom) && isset($data->email) && isset($data->motDePasse)) {
    
    // Sécurisation basique des entrées
    $nom = mysqli_real_escape_string($conn, htmlspecialchars($data->nom));
    $email = mysqli_real_escape_string($conn, htmlspecialchars($data->email));
    
    // Hachage du mot de passe pour la sécurité (très important en entreprise)
    $motDePasseHache = password_hash($data->motDePasse, PASSWORD_DEFAULT);
    
    // Rôle par défaut
    $role = 'Membre';

    // Requête d'insertion SQL
    $sql = "INSERT INTO Utilisateurs (Nom, Email, MotDePasse, Role) 
            VALUES ('$nom', '$email', '$motDePasseHache', '$role')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Inscription réussie ! Bienvenue sur ConnectHub."]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de l'inscription : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Veuillez remplir tous les champs."]);
}

mysqli_close($conn);
?>