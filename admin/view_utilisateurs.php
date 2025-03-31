<?php
session_start();
$utilisateurs = json_decode(file_get_contents('../data/utilisateurs.json'), true);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
</head>
<body>
    <h1>Liste des Utilisateurs</h1>
    <pre><?php print_r($utilisateurs); ?></pre>
    <a href="../accueil.php">Retour à l'accueil</a>
</body>
</html>
