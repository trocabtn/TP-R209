<?php
session_start();

// Détruire la session
session_unset();
session_destroy();

// Supprimer les cookies d'authentification persistante
setcookie('user_id', '', time() - 3600, '/');
setcookie('user_pseudo', '', time() - 3600, '/');

// Rediriger vers la page de connexion ou d'accueil
header('Location: connexion.php');
exit;
?>
