<?php
session_start();

include 'scripts/functions.php';

parametres();
entete();
navigation();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}

// Charger les données de l'utilisateur
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$utilisateur = null;

foreach ($utilisateurs as $u) {
    if ($u['utilisateur'] === $_SESSION['id']) {
        $utilisateur = $u;
        break;
    }
}

// Si l'utilisateur n'est pas trouvé, redirection
if (!$utilisateur) {
    header('Location: connexion.php');
    exit;
}

// Gestion des formulaires
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Modification du véhicule
    if (isset($_POST['vehicule'])) {
        $utilisateur['vehicule'] = $_POST['vehicule'];
    }

    // Modification de l'image de profil
    if (isset($_FILES['image_profil']) && $_FILES['image_profil']['error'] === UPLOAD_ERR_OK) {
        $dossierCible = 'uploads/';
        $nomFichier = basename($_FILES['image_profil']['name']);
        $cheminFichier = $dossierCible . $nomFichier;

        // Supprimer l'ancienne image si elle existe
        if (!empty($utilisateur['image_profil']) && file_exists($utilisateur['image_profil'])) {
            unlink($utilisateur['image_profil']);
        }

        // Déplacer le fichier téléchargé
        if (move_uploaded_file($_FILES['image_profil']['tmp_name'], $cheminFichier)) {
            $utilisateur['image_profil'] = $cheminFichier;
        }
    }

    // Mise à jour des données utilisateur
    foreach ($utilisateurs as &$u) {
        if ($u['utilisateur'] === $_SESSION['id']) {
            $u = $utilisateur;
            break;
        }
    }

    // Sauvegarder les modifications dans le fichier JSON
    file_put_contents('data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));

    header('Location: profil.php');
    exit;
}
?>

<body>
<h1 class="text-center my-4">Modifier votre profil</h1>

<div class="container">
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="vehicule" class="form-label">Véhicule</label>
            <input type="text" class="form-control" id="vehicule" name="vehicule" value="<?= htmlspecialchars($utilisateur['vehicule'] ?? '') ?>">
        </div>

        <div class="mb-3">
            <label for="image_profil" class="form-label">Image de profil</label>
            <input type="file" class="form-control" id="image_profil" name="image_profil">
            <?php if (!empty($utilisateur['image_profil'])): ?>
                <p>Image actuelle : <img src="<?= htmlspecialchars($utilisateur['image_profil']) ?>" alt="Image de profil" style="max-width: 100px;"></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</div>

<?php pieddepage(); ?>
</body>
</html>