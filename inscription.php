<?php
session_start();
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';
include 'scripts/functions.php';

parametres();
entete();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier que toutes les valeurs sont définies
    $pseudo = $_POST['pseudo'] ?? null;
    $email = $_POST['email'] ?? null;
    $vehicule = $_POST['vehicule'] ?? '';
    $password = $_POST['password'] ?? null;

    if ($pseudo && $email && $password) {
        // Vérifier si le pseudo est unique
        foreach ($utilisateurs as $user) {
            if ($user['pseudo'] === $pseudo) {
                $message = "Ce pseudo est déjà pris.";
                break;
            }
        }

        if (!$message) {
            $nouvel_utilisateur = [
                "pseudo" => htmlspecialchars($pseudo),
                "email" => htmlspecialchars($email),
                "vehicule" => htmlspecialchars($vehicule),
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ];

            $utilisateurs[] = $nouvel_utilisateur;
            file_put_contents('data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));

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
    <p><?php echo $message; ?></p>
    <form method="POST">
        Pseudo : <input type="text" name="pseudo" required><br>
        Email : <input type="email" name="email" required><br>
        Véhicule : <input type="text" name="vehicule"><br>
        Mot de passe : <input type="password" name="password" required><br>
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
