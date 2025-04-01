<?php
// filepath: c:\wamp64\www\TP-R209\modifier.php
session_start();

include 'scripts/functions.php';

parametres();
entete();
navigation();

// Charger les annonces depuis le fichier JSON
$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true);

if ($annonces === null || !is_array($annonces)) {
    echo '<p class="text-center text-danger">Erreur : Impossible de charger les annonces. Vérifiez le fichier JSON.</p>';
    exit;
}

// Vérifier si un ID d'annonce est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($annonces[(int)$_GET['id']])) {
    echo '<p class="text-center text-danger">Annonce introuvable.</p>';
    exit;
}

$id = (int)$_GET['id'];
$annonce = $annonces[$id];

// Vérifier les permissions : l'utilisateur doit être le créateur de l'annonce ou un modérateur
if ($_SESSION['id'] !== $annonce['Pseudo'] && ($_SESSION['role'] ?? '') !== 'admin') {
    echo '<p class="text-center text-danger">Vous n\'avez pas la permission de modifier cette annonce.</p>';
    exit;
}

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mettre à jour les données de l'annonce
    $annonces[$id] = [
        'Pseudo' => $annonce['Pseudo'], // Ne pas modifier le pseudo
        'Date' => $_POST['date'] . 'T' . $_POST['heure'],
        'Depart' => $_POST['ville_depart'] ?? '',
        'Arrivee' => $_POST['ville_arrivee'] ?? '',
        'Places' => (int)$_POST['places_disponibles'] ?? 0,
        'Commentaire' => $_POST['commentaire'] ?? '',
        'Inscrits' => $annonce['Inscrits'] // Conserver les inscrits
    ];

    // Sauvegarder les modifications dans le fichier JSON
    file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));

    // Rediriger vers la page de visualisation
    header('Location: visualiser.php');
    exit;
}
?>

<body>
    <h1 class="text-center my-4">Modifier une annonce</h1>

    <div class="container">
        <form method="POST">
            <div class="mb-3">
                <label for="date" class="form-label">Date de départ</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars(explode('T', $annonce['Date'])[0]) ?>" required>
            </div>

            <div class="mb-3">
                <label for="heure" class="form-label">Heure de départ</label>
                <input type="time" class="form-control" id="heure" name="heure" value="<?= htmlspecialchars(explode('T', $annonce['Date'])[1]) ?>" required>
            </div>

            <div class="mb-3">
                <label for="ville_depart" class="form-label">Ville de départ</label>
                <input type="text" class="form-control" id="ville_depart" name="ville_depart" value="<?= htmlspecialchars($annonce['Depart']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="ville_arrivee" class="form-label">Ville d'arrivée</label>
                <input type="text" class="form-control" id="ville_arrivee" name="ville_arrivee" value="<?= htmlspecialchars($annonce['Arrivee']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="places_disponibles" class="form-label">Places disponibles</label>
                <input type="number" class="form-control" id="places_disponibles" name="places_disponibles" value="<?= htmlspecialchars($annonce['Places']) ?>" min="1" required>
            </div>

            <div class="mb-3">
                <label for="commentaire" class="form-label">Commentaire libre</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"><?= htmlspecialchars($annonce['Commentaire']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </form>
    </div>

    <?php pieddepage(); ?>
</body>
</html>