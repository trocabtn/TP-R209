<?php
session_start();
include 'scripts/functions.php';

parametres();
entete();
navigation();

$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true) ?? [];
if (!isset($_SESSION['id'])) {
    echo '<p class="text-center text-danger">Vous devez être connecté pour accéder à cette page.</p>';
    exit;
}

$isModerator = isset($_SESSION['role']) && ($_SESSION['role'] === 'modo' || $_SESSION['role'] === 'admin');
$annoncesUtilisateur = [];
foreach ($annonces as $index => $annonce) {
    if ($isModerator || (isset($annonce['Pseudo']) && $annonce['Pseudo'] === $_SESSION['id'])) {
        $annoncesUtilisateur[$index] = $annonce;
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['index'])) {
    $index = (int)$_GET['index'];
    if ($isModerator || (isset($annonces[$index]) && $annonces[$index]['Pseudo'] === $_SESSION['id'])) {
        unset($annonces[$index]);
        $annonces = array_values($annonces);
        file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));
        header('Location: modifier.php');
        exit;
    } else {
        echo '<p class="text-center text-danger">Vous n\'avez pas la permission de supprimer cette annonce.</p>';
    }
}
?>

<body>
    <h1 class="text-center my-4">Modifier ou supprimer des annonces</h1>

    <div class="container">
        <?php if (!empty($annoncesUtilisateur)): ?>
            <ul class="list-group">
                <?php foreach ($annoncesUtilisateur as $index => $annonce): ?>
                    <li class="list-group-item">
                        <strong>Départ :</strong> <?= htmlspecialchars($annonce['Depart']) ?> →
                        <strong>Arrivée :</strong> <?= htmlspecialchars($annonce['Arrivee']) ?><br>
                        <strong>Date :</strong> <?= htmlspecialchars($annonce['Date']) ?><br>
                        <a href="modifier_annonce.php?index=<?= $index ?>" class="btn btn-primary btn-sm mt-2">Modifier</a>
                        <a href="modifier.php?action=delete&index=<?= $index ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');">Supprimer</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Aucune annonce disponible.</p>
        <?php endif; ?>
    </div>

    <?php pieddepage(); ?>
</body>
</html>