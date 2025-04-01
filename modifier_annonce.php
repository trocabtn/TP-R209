<?php
// filepath: c:\wamp64\www\TP-R209\modifier_annonce.php
session_start();

include 'scripts/functions.php';

parametres();
entete();
navigation();

// Charger les annonces depuis le fichier JSON
$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true) ?? [];

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    echo '<p class="text-center text-danger">Vous devez être connecté pour modifier une annonce.</p>';
    exit;
}

// Vérifier si un index est passé dans l'URL
if (!isset($_GET['index'])) {
    echo '<p class="text-center text-danger">Aucune annonce spécifiée.</p>';
    exit;
}

$index = (int)$_GET['index'];
$annonce = $annonces[$index] ?? null;

$isModerator = isset($_SESSION['isModerator']) && $_SESSION['isModerator'];

if ($annonce === null || (!$isModerator && $annonce['Pseudo'] !== $_SESSION['id'])) {
    echo '<p class="text-center text-danger">Vous n\'avez pas la permission de modifier cette annonce.</p>';
    exit;
}

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mettre à jour les données de l'annonce
    $annonce['Date'] = $_POST['date'] . 'T' . $_POST['heure'];
    $annonce['Depart'] = $_POST['ville_depart'] ?? '';
    $annonce['Arrivee'] = $_POST['ville_arrivee'] ?? '';
    $annonce['Places'] = (int)$_POST['places_disponibles'] ?? 0;
    $annonce['Commentaire'] = $_POST['commentaire'] ?? '';

    // Sauvegarder les modifications dans le fichier JSON
    file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));

    // Rediriger vers la page de modification
    header('Location: modifier.php');
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