<?php
session_start();
$annonces = json_decode(file_get_contents('../data/annonces.json'), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Annonces</title>
</head>
<body>
    <h1>Liste des Annonces</h1>
    <pre><?php print_r($annonces); ?></pre>
    <a href="../accueil.php">Retour à l'accueil</a>
</body>
</html>
