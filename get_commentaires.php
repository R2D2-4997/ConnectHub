<?php
require_once("config.php");

$pub_id = isset($_GET['pub_id']) ? (int)$_GET['pub_id'] : 0;

if ($pub_id > 0) {
    $sql = "SELECT c.ID, c.Contenu, c.Date_Commentaire, u.Nom 
            FROM Commentaires c
            JOIN Utilisateurs u ON c.Auteur_ID = u.ID
            WHERE c.Publication_ID = $pub_id
            ORDER BY c.Date_Commentaire ASC";

    $result = mysqli_query($conn, $sql);
    $commentaires = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $commentaires[] = $row;
        }
        echo json_encode($commentaires);
    } else {
        echo json_encode(["erreur" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["erreur" => "ID de publication manquant."]);
}

mysqli_close($conn);
?>