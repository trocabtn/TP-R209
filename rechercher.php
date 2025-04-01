<?php
session_start();
include 'scripts/functions.php';

parametres();
entete();
navigation();

$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true) ?? [];
$criteres = [
    'date' => $_GET['date'] ?? '',
    'places' => $_GET['places'] ?? '',
    'depart' => $_GET['depart'] ?? '',
    'arrivee' => $_GET['arrivee'] ?? ''
];
$annoncesFiltrees = array_filter($annonces, function ($annonce) use ($criteres) {
    if (!empty($criteres['date']) && strpos($annonce['Date'], $criteres['date']) === false) {
        return false;
    }
    if (!empty($criteres['places']) && $annonce['Places'] < (int)$criteres['places']) {
        return false;
    }
    if (!empty($criteres['depart']) && stripos($annonce['Depart'], $criteres['depart']) === false) {
        return false;
    }
    if (!empty($criteres['arrivee']) && stripos($annonce['Arrivee'], $criteres['arrivee']) === false) {
        return false;
    }
    return true;
});
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
    <h1 class="text-center my-4">Rechercher des annonces</h1>

    <div class="container">
        <form method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($criteres['date']) ?>">
                </div>
                <div class="col-md-3">
                    <label for="places" class="form-label">Places disponibles</label>
                    <input type="number" class="form-control" id="places" name="places" value="<?= htmlspecialchars($criteres['places']) ?>" min="1">
                </div>
                <div class="col-md-3">
                    <label for="depart" class="form-label">Ville de départ</label>
                    <input type="text" class="form-control" id="depart" name="depart" value="<?= htmlspecialchars($criteres['depart']) ?>">
                </div>
                <div class="col-md-3">
                    <label for="arrivee" class="form-label">Ville d'arrivée</label>
                    <input type="text" class="form-control" id="arrivee" name="arrivee" value="<?= htmlspecialchars($criteres['arrivee']) ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Rechercher</button>
        </form>
        <?php if (!empty($annoncesFiltrees)): ?>
            <ul class="list-group">
                <?php foreach ($annoncesFiltrees as $index => $annonce): ?>
                    <li class="list-group-item">
                        <strong>Départ :</strong> <?= htmlspecialchars($annonce['Depart']) ?> →
                        <strong>Arrivée :</strong> <?= htmlspecialchars($annonce['Arrivee']) ?><br>
                        <strong>Date :</strong> <?= htmlspecialchars($annonce['Date']) ?><br>
                        <strong>Places disponibles :</strong> <?= htmlspecialchars($annonce['Places']) ?><br>
                        <strong>Commentaire :</strong> <?= htmlspecialchars($annonce['Commentaire']) ?><br>
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="rechercher.php?action=inscrire&index=<?= $index ?>" class="btn btn-success btn-sm mt-2">S'inscrire</a>
                        <?php else: ?>
                            <p class="text-danger mt-2">Connectez-vous pour vous inscrire.</p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-center">Aucune annonce ne correspond à vos critères.</p>
        <?php endif; ?>
    </div>
    <?php pieddepage(); ?>
</body>
</html>