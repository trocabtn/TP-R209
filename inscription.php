<?php
session_start();
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';
include 'scripts/functions.php';

// Vérification du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? '';
    $vehicule = $_POST['vehicule'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    // Vérification des champs
    if (empty($pseudo) || empty($vehicule) || empty($email) || empty($password) || empty($password_confirm)) {
        $message = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $password_confirm) {
        $message = 'Les mots de passe ne correspondent pas.';
    } else {
        // Vérification de l'unicité du pseudo et de l'email
        $pseudo_existe = false;
        $email_existe = false;
        foreach ($utilisateurs as $utilisateur) {
            if (isset($utilisateur['pseudo']) && $utilisateur['pseudo'] === $pseudo) {
                $pseudo_existe = true;
            }
            if (isset($utilisateur['email']) && $utilisateur['email'] === $email) {
                $email_existe = true;
            }
        }

        if ($pseudo_existe) {
            $message = 'Ce pseudo est déjà utilisé.';
        } elseif ($email_existe) {
            $message = 'Cette adresse email est déjà utilisée.';
        } else {
            // Hachage du mot de passe
            $password_hache = password_hash($password, PASSWORD_DEFAULT);

            // Ajout du nouvel utilisateur
            $nouvel_utilisateur = [
                'id' => count($utilisateurs) + 1,
                'pseudo' => $pseudo,
                'vehicule' => $vehicule,
                'email' => $email,
                'password' => $password_hache
            ];
            $utilisateurs[] = $nouvel_utilisateur;

            // Sauvegarde dans le fichier JSON
            file_put_contents('data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));

            $message = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
        }
    }
}

parametres();
entete();
?>

<body>
    <div class="container mt-5">
        <h2>Inscription</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo strpos($message, 'réussie') !== false ? 'success' : 'danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="mb-3">
                <label for="vehicule" class="form-label">Type de véhicule</label>
                <input type="text" class="form-control" id="vehicule" name="vehicule" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password_confirm" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>
</body>

<?php
pieddepage();
?>

