<?php
// 1. Autoriser les requêtes CORS (indispensable pour séparer Front et Back)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// 2. Paramètres de connexion à la base de données (WAMP par défaut)
$host = "localhost";
$user = "root";       // Utilisateur par défaut sous WAMP
$password = "";       // Mot de passe vide par défaut sous WAMP
$dbname = "ConnectHubDB"; // Le nom de la base que nous avons créée

// 3. Connexion avec mysqli
$conn = mysqli_connect($host, $user, $password, $dbname);

// 4. Vérification de la connexion
if (!$conn) {
    // Si erreur, on renvoie du JSON pour que React puisse l'interpréter
    die(json_encode(["erreur" => "Erreur de connexion à la base de données: " . mysqli_connect_error()]));
}
?>