<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur'])) {
    header('Location: connexion.php');
    exit;
}

// Charger les données nécessaires
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$annonces = json_decode(file_get_contents('data/annonces.json'), true);

include 'scripts/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['utilisateur'] ?? ''; // Récupérer le pseudo depuis le formulaire
    $password = $_POST['password'] ?? ''; // Récupérer le mot de passe depuis le formulaire

    foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['utilisateur'] === $pseudo) { // Vérifier le pseudo
            if (password_verify($password, $utilisateur['motdepasse'])) {
                // Définir les informations de session
                $_SESSION['utilisateur'] = $utilisateur['utilisateur'];
                $_SESSION['role'] = $utilisateur['role'];

                // Redirection vers la page d'accueil
                header('Location: acceuil.php');
                exit;
            } else {
                $message = 'Mot de passe incorrect.';
            }
        }
    }

    if (empty($message)) {
        $message = 'Utilisateur non trouvé.';
    }
}

parametres();
entete();
navigation();
?>

<body>
<h1 class="text-center my-4">Bienvenue chez CarCarBla !</h1>

<div class="container">
    <div class="row text-center my-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Nombre d'utilisateurs</h5>
                <p class="display-6"><?= count($utilisateurs); ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Nombre d'annonces</h5>
                <p class="display-6"><?= count($annonces); ?></p>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="row text-center my-4">
            <div class="col-12">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Administration</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="admin/view_utilisateurs.php" class="btn btn-primary">Voir les utilisateurs</a>
                        <a href="admin/view_annonces.php" class="btn btn-primary">Voir les annonces</a>
                        <a href="administration.php" class="btn btn-primary">Page d'administration</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php pieddepage(); ?>
</body>
</html>
