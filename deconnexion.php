<?php
session_start();

// Détruire la session
session_unset();
session_destroy();

// Rediriger vers la page de connexion
header('Location: connexion.php');
exit;
?>
