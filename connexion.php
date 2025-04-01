<?php
session_start();
include 'scripts/functions.php';

// Charger les utilisateurs depuis le fichier JSON
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION['utilisateur'])) {
    header('Location: acceuil.php');
    exit;
}

// Vérification du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = $_POST['pseudo'] ?? ''; // Récupérer le pseudo depuis le formulaire
    $password = $_POST['password'] ?? ''; // Récupérer le mot de passe depuis le formulaire

    // Recherche de l'utilisateur dans le fichier JSON
    foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['utilisateur'] === $pseudo) { // Vérifier le pseudo
            // Vérification du mot de passe avec le hash stocké
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
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Connexion</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-danger text-center"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="pseudo" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
        </form>
    </div>
    <?php pieddepage(); ?>
</body>
</html>