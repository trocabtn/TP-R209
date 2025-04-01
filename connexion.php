<?php
session_start();
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';
include 'scripts/functions.php';

// Vérification du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['utilisateur'] ?? ''; // Récupérer le pseudo depuis le formulaire
    $password = $_POST['password'] ?? '';

    // Recherche de l'utilisateur dans le fichier JSON
    foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['utilisateur'] === $pseudo) { // Vérifier le pseudo
            // Vérification du mot de passe avec le hash stocké
            if (password_verify($password, $utilisateur['password'])) {
                $_SESSION['id'] = $utilisateur['id'];
                $_SESSION['utilisateur'] = $utilisateur['pseudo'];

                // Gestion des cookies pour l'authentification persistante (bonus)
                if (!empty($_POST['remember'])) {
                    setcookie('user_id', $utilisateur['id'], time() + (86400 * 30), '/'); // 30 jours
                    setcookie('user_pseudo', $utilisateur['pseudo'], time() + (86400 * 30), '/');
                }

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
    <div class="container mt-5">
        <h2>Connexion</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>

<?php
pieddepage();
?>