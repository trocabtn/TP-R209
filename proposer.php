<?php
// filepath: c:\wamp64\www\TP-R209\proposer.php
session_start();

include 'scripts/functions.php';

parametres();
entete();
navigation();

// Charger les annonces existantes depuis le fichier JSON
$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true) ?? [];

// Ajouter un ID unique aux annonces qui n'ont pas de clé "id-annonce"
foreach ($annonces as &$annonce) {
    if (!isset($annonce['id-annonce'])) {
        $annonce['id-annonce'] = uniqid($annonce['Pseudo'] . '-', true);
    }
}

// Sauvegarder les modifications dans le fichier JSON
file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));

// Charger les utilisateurs depuis le fichier JSON
$utilisateursFile = 'data/utilisateurs.json';
$utilisateurs = json_decode(file_get_contents($utilisateursFile), true) ?? [];

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Générer un ID unique pour l'annonce
    $idAnnonce = uniqid($_SESSION['id'] . '-', true);

    // Récupérer les données du formulaire
    $nouvelleAnnonce = [
        'id-annonce' => $idAnnonce, // ID unique de l'annonce
        'Pseudo' => $_SESSION['id'] ?? 'Anonyme',
        'Date' => $_POST['date'] . 'T' . $_POST['heure'],
        'Depart' => $_POST['ville_depart'] ?? '',
        'Arrivee' => $_POST['ville_arrivee'] ?? '',
        'Places' => (int)$_POST['places_disponibles'] ?? 0,
        'Commentaire' => $_POST['commentaire'] ?? '',
        'Inscrits' => []
    ];

    // Ajouter la nouvelle annonce à la liste
    $annonces[] = $nouvelleAnnonce;

    // Sauvegarder les annonces dans le fichier JSON
    file_put_contents($annoncesFile, json_encode($annonces, JSON_PRETTY_PRINT));

    // Ajouter l'ID de l'annonce à l'utilisateur dans utilisateurs.json
    foreach ($utilisateurs as &$utilisateur) {
        if ($utilisateur['utilisateur'] === $_SESSION['id']) {
            if (!isset($utilisateur['id_annonce'])) {
                $utilisateur['id_annonce'] = []; // Initialiser la clé si elle n'existe pas
            }
            $utilisateur['id_annonce'][] = $idAnnonce; // Ajouter l'ID de l'annonce
            break;
        }
    }

    // Sauvegarder les modifications dans le fichier utilisateurs.json
    file_put_contents($utilisateursFile, json_encode($utilisateurs, JSON_PRETTY_PRINT));

    // Rediriger vers la page de visualisation
    header('Location: visualiser.php');
    exit;
}
?>

<body>
    <h1 class="text-center my-4">Proposer une annonce de covoiturage</h1>

    <div class="container">
        <form method="POST">
            <div class="mb-3">
                <label for="date" class="form-label">Date de départ</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="mb-3">
                <label for="heure" class="form-label">Heure de départ</label>
                <input type="time" class="form-control" id="heure" name="heure" required>
            </div>

            <div class="mb-3">
                <label for="ville_depart" class="form-label">Ville de départ</label>
                <input type="text" class="form-control" id="ville_depart" name="ville_depart" required>
            </div>

            <div class="mb-3">
                <label for="ville_arrivee" class="form-label">Ville d'arrivée</label>
                <input type="text" class="form-control" id="ville_arrivee" name="ville_arrivee" required>
            </div>

            <div class="mb-3">
                <label for="places_disponibles" class="form-label">Places disponibles</label>
                <input type="number" class="form-control" id="places_disponibles" name="places_disponibles" min="1" required>
            </div>

            <div class="mb-3">
                <label for="commentaire" class="form-label">Commentaire libre</label>
                <textarea class="form-control" id="commentaire" name="commentaire" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Proposer l'annonce</button>
        </form>
    </div>

    <?php pieddepage(); ?>
</body>
</html>