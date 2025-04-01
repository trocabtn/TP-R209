<?php
session_start();
include 'scripts/functions.php';
parametres();
entete();
navigation();

$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true) ?? [];

if (isset($_GET['action']) && $_GET['action'] === 'inscrire' && isset($_GET['index'])) {
    if (!isset($_SESSION['id'])) {
        echo '<p class="text-center text-danger">Vous devez être connecté pour vous inscrire à une annonce.</p>';
    } else {
        $index = (int)$_GET['index'];
        if (isset($annonces[$index])) {
            $annonce = &$annonces[$index];
            if (!in_array($_SESSION['id'], $annonce['Inscrits'])) {
                $annonce['Inscrits'][] = $_SESSION['id'];
                file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));
                echo '<p class="text-center text-success">Vous êtes inscrit à cette annonce.</p>';
            } else {
                echo '<p class="text-center text-warning">Vous êtes déjà inscrit à cette annonce.</p>';
            }
        }
    }
}
?>

<body>
    <h1 class="text-center my-4">Visualiser les annonces</h1>

    <div class="container">
        <?php if (!empty($annonces)): ?>
            <div class="row">
                <?php foreach ($annonces as $index => $annonce): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><strong>Départ :</strong> <?= htmlspecialchars($annonce['Depart']) ?> → <strong>Arrivée :</strong> <?= htmlspecialchars($annonce['Arrivee']) ?></h5>
                                <p class="card-text"><strong>Date :</strong> <?= htmlspecialchars($annonce['Date']) ?></p>
                                <p class="card-text"><strong>Places disponibles :</strong> <?= htmlspecialchars($annonce['Places']) ?></p>
                                <p class="card-text"><strong>Commentaire :</strong> <?= htmlspecialchars($annonce['Commentaire']) ?></p>
                                <?php if (isset($_SESSION['id'])): ?>
                                    <a href="visualiser.php?action=inscrire&index=<?= $index ?>" class="btn btn-success btn-sm">S'inscrire</a>
                                <?php else: ?>
                                    <p class="text-danger mt-2">Connectez-vous pour vous inscrire.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php if (($index + 1) % 3 === 0): ?>
                        </div><div class="row">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucune annonce disponible.</p>
        <?php endif; ?>
    </div>

    <?php pieddepage(); ?>
</body>
</html>