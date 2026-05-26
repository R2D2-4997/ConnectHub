<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->titre) && !empty($data->lieu) && !empty($data->date_evenement)) {
    $titre = mysqli_real_escape_string($conn, $data->titre);
    $description = mysqli_real_escape_string($conn, $data->description);
    $lieu = mysqli_real_escape_string($conn, $data->lieu);
    $date_evenement = mysqli_real_escape_string($conn, $data->date_evenement);

    // Insertion conforme au pluriel de votre table MySQL
    $sql = "INSERT INTO evenements (Titre, Description, Lieu, Date_evenement) 
            VALUES ('$titre', '$description', '$lieu', '$date_evenement')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["succes" => "Session sportive organisée avec succès !"]);
    } else {
        echo json_encode(["erreur" => "Erreur de base de données : " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "Veuillez remplir tous les champs obligatoires."]);
}
mysqli_close($conn);
?>