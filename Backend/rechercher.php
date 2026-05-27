<?php
require_once("config.php");
$data = json_decode(file_get_contents("php://input"));

if (isset($data->requete) && isset($data->type)) {
    $req = mysqli_real_escape_string($conn, $data->requete);
    $type = $data->type;
    $resultats = [];

    // 1. Recherche d'Athlètes
    if ($type === 'utilisateurs' || $type === 'tous') {
        $sql = "SELECT ID, Nom, Role, 'utilisateur' AS Type_Source FROM utilisateurs WHERE Nom LIKE '%$req%'";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) { $resultats[] = $row; }
    }

    // 2. Recherche de Communautés
    if ($type === 'communautes' || $type === 'tous') {
        $sql = "SELECT ID, Nom, Description, 'communaute' AS Type_Source FROM communautes WHERE Nom LIKE '%$req%' OR Description LIKE '%$req%'";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) { $resultats[] = $row; }
    }

    // 3. Recherche de Publications
    if ($type === 'publications' || $type === 'tous') {
        $sql = "SELECT p.ID, p.Contenu, p.Auteur_ID, u.Nom, 'publication' AS Type_Source 
                FROM publications p JOIN utilisateurs u ON p.Auteur_ID = u.ID 
                WHERE p.Contenu LIKE '%$req%'";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) { $resultats[] = $row; }
    }

    // 4. Recherche d'Événements
    if ($type === 'evenements' || $type === 'tous') {
        $sql = "SELECT ID, Titre AS Nom, Description, Lieu, 'evenement' AS Type_Source FROM evenements WHERE Titre LIKE '%$req%' OR Description LIKE '%$req%' OR Lieu LIKE '%$req%'";
        $res = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($res)) { $resultats[] = $row; }
    }

    echo json_encode($resultats);
} else {
    echo json_encode([]);
}
mysqli_close($conn);
?>