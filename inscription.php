<?php
session_start();
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';
include 'scripts/functions.php';

parametres();
entete();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des champs avec sécurité
    $pseudo = $_POST['pseudo'] ?? '';
    $email = $_POST['email'] ?? '';
    $vehicule = $_POST['vehicule'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérification des champs obligatoires
    if (!empty($pseudo) && !empty($email) && !empty($password)) {
        // Vérifier si le pseudo est unique
        $pseudoPris = false;
        foreach ($utilisateurs as $user) {
            if ($user['pseudo'] === $pseudo) {
                $pseudoPris = true;
                $message = "Ce pseudo est déjà pris.";
                break;
            }
        }

        // Ajouter le nouvel utilisateur si le pseudo est libre
        if (!$pseudoPris) {
            $nouvel_utilisateur = [
                "pseudo" => htmlspecialchars($pseudo),
                "email" => htmlspecialchars($email),
                "vehicule" => htmlspecialchars($vehicule),
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];

            $utilisateurs[] = $nouvel_utilisateur;
            file_put_contents('data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));

            // Redirection vers la page de connexion
            header('Location: connexion.php');
            exit;
        }
    } else {
        $message = "Tous les champs sont requis.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <?php if (!empty($message)) : ?>
        <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="pseudo">Pseudo :</label>
        <input type="text" id="pseudo" name="pseudo" required><br>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>

        <label for="vehicule">Véhicule :</label>
        <input type="text" id="vehicule" name="vehicule"><br>

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
s