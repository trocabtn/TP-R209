<?php
session_start();
include 'scripts/functions.php';

parametres();
entete();
navigation();

if (!isset($_SESSION['id'])) {
    header('Location: connexion.php');
    exit;
}
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$utilisateur = null;
foreach ($utilisateurs as $u) {
    if ($u['utilisateur'] === $_SESSION['id']) {
        $utilisateur = $u;
        break;
    }
}
if (!$utilisateur) {
    header('Location: connexion.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vehicule'])) {
        $utilisateur['vehicule'] = $_POST['vehicule'];
    }
    if (isset($_FILES['image_profil']) && $_FILES['image_profil']['error'] === UPLOAD_ERR_OK) {
        $dossierCible = 'images/';
        if (!is_dir($dossierCible)) {
            mkdir($dossierCible, 0777, true);
        }
        $extension = pathinfo($_FILES['image_profil']['name'], PATHINFO_EXTENSION);
        $nomFichier = $_SESSION['id'] . '.' . $extension;
        $cheminFichier = $dossierCible . $nomFichier;
        if (!empty($utilisateur['image_profil']) && file_exists($utilisateur['image_profil'])) {
            unlink($utilisateur['image_profil']);
        }
        if (move_uploaded_file($_FILES['image_profil']['tmp_name'], $cheminFichier)) {
            $utilisateur['image_profil'] = $cheminFichier;
            $_SESSION['image_profil'] = $cheminFichier;
        } else {
            echo "Erreur : Impossible de déplacer le fichier téléchargé.";
        }
    } else {
        if (isset($_FILES['image_profil']['error']) && $_FILES['image_profil']['error'] !== UPLOAD_ERR_NO_FILE) {
            echo "Erreur lors du téléchargement de l'image : Code " . $_FILES['image_profil']['error'];
        }
    }
    foreach ($utilisateurs as &$u) {
        if ($u['utilisateur'] === $_SESSION['id']) {
            $u = $utilisateur;
            break;
        }
    }
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

<div class="user-profile d-flex align-items-center">
    <span class="user-label me-2">Nom d'utilisateur :</span>
    <span class="user-name me-3"><strong><?= htmlspecialchars($utilisateur['utilisateur']) ?></strong></span>
    <?php if (!empty($utilisateur['image_profil'])): ?>
        <img src="<?= htmlspecialchars($utilisateur['image_profil']) ?>" alt="Photo de profil" class="profile-circle">
    <?php else: ?>
        <img src="images/photo_de_profil_par_defaut.jpg" alt="Photo de profil par défaut" class="profile-circle">
    <?php endif; ?>
</div>

<?php pieddepage(); ?>
</body>
</html>