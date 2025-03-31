<?php
session_start();
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';
include 'scripts/functions.php';
parametres();
entete();
navigation();
pieddepage();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($utilisateurs as $user) {
        if ($user['email'] === $_POST['email'] && password_verify($_POST['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            if (!empty($_POST['remember'])) {
                setcookie('email', $_POST['email'], time() + 3600 * 24 * 30, "/");
            }
            header('Location: accueil.php');
            exit;
        }
    }
    $message = "Identifiants incorrects.";
}
?>


<body>
    <h1>Connexion</h1>
    <p><?php echo $message; ?></p>
    <form method="POST">
        Email : <input type="email" name="email" required><br>
        Mot de passe : <input type="password" name="password" required><br>
        <input type="checkbox" name="remember"> Se souvenir de moi<br>
        <input type="submit" value="Se connecter">
    </form>
</body>