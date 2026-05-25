<?php
require_once("config.php");

$data = json_decode(file_get_contents("php://input"));

if (isset($data->nom) && isset($data->createur_id)) {
    // Sécurisation
    $nom = mysqli_real_escape_string($conn, htmlspecialchars($data->nom));
    $description = isset($data->description) ? mysqli_real_escape_string($conn, htmlspecialchars($data->description)) : '';
    $createur_id = (int) $data->createur_id;

    // 1. Insertion de la nouvelle communauté
    $sql_creation = "INSERT INTO Communautes (Nom, Description, Createur_ID) VALUES ('$nom', '$description', $createur_id)";

    if (mysqli_query($conn, $sql_creation)) {
        // On récupère l'ID du groupe fraîchement créé
        $nouvelle_communaute_id = mysqli_insert_id($conn);
        
        // 2. On ajoute automatiquement le créateur comme premier membre du groupe
        $sql_membre = "INSERT INTO Membres_Communautes (Communaute_ID, Utilisateur_ID) VALUES ($nouvelle_communaute_id, $createur_id)";
        mysqli_query($conn, $sql_membre);

        echo json_encode(["succes" => "Votre groupe d'entraînement a été créé avec succès !"]);
    } else {
        echo json_encode(["erreur" => "Erreur lors de la création : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Le nom du groupe est obligatoire."]);
}

mysqli_close($conn);
?>