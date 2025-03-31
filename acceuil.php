<?php
session_start();
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$annonces = json_decode(file_get_contents('data/annonces.json'), true);
include 'scripts/functions.php';

parametres();
entete();
navigation();
?>

<body>
    <h1>Bienvenue sur le site</h1>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Connecté en tant que : <strong><?= htmlspecialchars($_SESSION['user']['pseudo']); ?></strong></p>
        <a href="profil.php">Modifier mon profil</a> | 
        <a href="deconnexion.php">Se déconnecter</a>
    <?php else: ?>
        <p><a href="connexion.php">Se connecter</a> | <a href="inscription.php">S'inscrire</a></p>
    <?php endif; ?>

    <p>Nombre d'utilisateurs : <?= count($utilisateurs); ?></p>
    <p>Nombre d'annonces : <?= count($annonces); ?></p>

    <h2>Navigation</h2>
    <ul>
        <li><a href="admin/view_utilisateurs.php">Voir les utilisateurs</a></li>
        <li><a href="admin/view_annonces.php">Voir les annonces</a></li>
        <li><a href="administration.php">Administration</a></li>
    </ul>

    <?php pieddepage(); ?>
</body>
</html>
