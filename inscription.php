<?php
session_start();
include 'scripts/functions.php';

parametres();
entete();
navigation();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($pseudo) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $confirm_password) {
        $message = 'Les mots de passe ne correspondent pas.';
    } else {
        $file_path = __DIR__ . '/data/utilisateurs.json';
        $utilisateurs = json_decode(file_get_contents($file_path), true) ?? [];
        foreach ($utilisateurs as $utilisateur) {
            if ($utilisateur['utilisateur'] === $pseudo) {
                $message = 'Ce pseudo est déjà utilisé.';
                break;
            }
            if ($utilisateur['email'] === $email) {
                $message = 'Cet email est déjà utilisé.';
                break;
            }
        }
        if (empty($message)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $nouvel_utilisateur = [
                'utilisateur' => $pseudo,
                'email' => $email,
                'motdepasse' => $hashed_password,
                'role' => 'user'
            ];
            $utilisateurs[] = $nouvel_utilisateur;
            file_put_contents($file_path, json_encode($utilisateurs, JSON_PRETTY_PRINT));
            header('Location: connexion.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Inscription</h1>
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </form>
    </div>

    <?php pieddepage(); ?>
</body>
</html>

