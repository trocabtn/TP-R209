<?php

function parametres($param=""){
    $path = $_SERVER['PHP_SELF']; 
    $file = basename ($path);

    echo '
    <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$file.'</title>
        <script src="'.$param.'scripts"></script>
        <link rel="stylesheet" href="'.$param.'css/style.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
        <style>
        @import url("https://fonts.googleapis.com/css2?family=Gloria+Hallelujah&display=swap");
        .gloria-hallelujah-regular {
        font-family: "Gloria Hallelujah", cursive;
        font-weight: 400;
        font-style: normal;
        }
        </style>
        ';
}

function entete($prefix = '') {
    echo '
    <header class="py-3 mb-4 border-bottom animate__animated animate__fadeInDown">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <a href="' . $prefix . 'acceuil.php" class="text-dark text-decoration-none text-center">
                    <img src="' . $prefix . 'images/logo.png" alt="Logo CarCarBla" style="height: 50px; margin-right: 10px;" class="animate__animated animate__zoomIn">
                    <span class="fs-3 gloria-hallelujah-regular">CarCarBla</span>
                </a>
            </div>
        </div>
    </header>';
}

function navigation($prefix = '') {
    $currentPage = basename($_SERVER['PHP_SELF']);

    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    echo '<div class="container-fluid">';
    echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</button>';
    echo '<div class="collapse navbar-collapse" id="navbarNav">';
    echo '<ul class="navbar-nav me-auto">';
    echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'acceuil.php' ? 'active' : '') . '" href="' . $prefix . 'acceuil.php">Accueil</a></li>';
    echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'rechercher.php' ? 'active' : '') . '" href="' . $prefix . 'rechercher.php">Rechercher des annonces</a></li>';
    echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'visualiser.php' ? 'active' : '') . '" href="' . $prefix . 'visualiser.php">Visualiser les annonces</a></li>';
    echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'calendar.php' ? 'active' : '') . '" href="' . $prefix . 'calendar.php">Calendrier</a></li>';
    if (isset($_SESSION['id'])) {
        echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'proposer.php' ? 'active' : '') . '" href="' . $prefix . 'proposer.php">Proposer une annonce</a></li>';
        echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'modifier.php' ? 'active' : '') . '" href="' . $prefix . 'modifier.php">Modifier une annonce</a></li>';
    }
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'view_utilisateurs.php' ? 'active' : '') . '" href="' . $prefix . 'admin/view_utilisateurs.php">Voir les utilisateurs</a></li>';
        echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'view_annonces.php' ? 'active' : '') . '" href="' . $prefix . 'admin/view_annonces.php">Voir les annonces</a></li>';
        echo '<li class="nav-item"><a class="nav-link ' . ($currentPage === 'administration.php' ? 'active' : '') . '" href="' . $prefix . 'administration.php">Administration</a></li>';
    }
    echo '</ul>';
    echo '<ul class="navbar-nav">';
    if (isset($_SESSION['id'])) {
        echo '<li class="nav-item d-flex align-items-center">';
        echo '<span class="user-label-navbar me-2">Nom d\'utilisateur :</span>';
        echo '<span class="user-name-navbar me-3">' . htmlspecialchars($_SESSION['id']) . '</span>';
        if (!empty($_SESSION['image_profil'])) {
            echo '<img src="' . htmlspecialchars($_SESSION['image_profil']) . '" alt="Photo de profil" class="profile-circle-navbar">';
        } else {
            echo '<img src="' . $prefix . 'images/photo_de_profil_par_defaut.jpg" alt="Photo de profil par défaut" class="profile-circle-navbar">';
        }
        echo '</li>';
        echo '<li class="nav-item"><a class="nav-link text-danger" href="' . $prefix . 'deconnexion.php">Déconnexion</a></li>';
    } else {
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'connexion.php">Connexion</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'inscription.php">Inscription</a></li>';
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</nav>';

    // Ligne de recherche sous la barre de navigation
    echo '<div class="container mt-2">';
    echo '<div class="d-flex justify-content-end">';
    echo '<form class="d-flex" action="#" method="GET">';
    echo '<input class="form-control me-2" type="search" placeholder="Rechercher" aria-label="Rechercher">';
    echo '<button class="btn btn-outline-primary" type="submit">Rechercher</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
}

function pieddepage() {
    date_default_timezone_set('Europe/Paris');
    $heureActuelle = date('H:i:s');

    echo '
    <footer class="footer bg-light py-4 mt-5 animate__animated animate__fadeInUp">
        <div class="container text-center">
            <p class="mb-1"><strong>Robin BATON</strong> - robin.baton@etudiant.univ-rennes.fr - G1</p>
            <p class="mb-1">&copy; ' . date('Y') . ' CarCarBla. Tous droits réservés.</p>
            <p class="mb-1">IP : ' . ($_SERVER['REMOTE_ADDR'] === '::1' ? '127.0.0.1' : $_SERVER['REMOTE_ADDR']) . ' | Port : ' . $_SERVER['REMOTE_PORT'] . '</p>
            <p class="mb-1">Heure actuelle : ' . $heureActuelle . '</p>
            <div class="d-flex justify-content-center mt-2">
                <a href="#" class="mx-2 text-dark animate__animated animate__fadeInLeft">Instagram</a>
                <a href="#" class="mx-2 text-dark animate__animated animate__fadeInUp">LinkedIn</a>
                <a href="#" class="mx-2 text-dark animate__animated animate__fadeInRight">Twitter</a>
            </div>
        </div>
    </footer>
    ';
}

function afficherLienDeconnexion($prefix = '') {
    if (isset($_SESSION['id'])) {
        echo '<a href="' . $prefix . 'deconnexion.php" class="btn btn-danger">Déconnexion</a>';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $utilisateurs = json_decode(file_get_contents(__DIR__ . '/../data/utilisateurs.json'), true);
    if (!is_array($utilisateurs)) {
        $utilisateurs = [];
    }
    $pseudo = $_POST['pseudo'] ?? '';
    $password = $_POST['password'] ?? '';
    $utilisateurTrouve = false;
    foreach ($utilisateurs as $utilisateur) {
        if (isset($utilisateur['utilisateur'], $utilisateur['motdepasse'], $utilisateur['role']) &&
            $utilisateur['utilisateur'] === $pseudo) {
            if (password_verify($password, $utilisateur['motdepasse'])) {
                $_SESSION['id'] = $utilisateur['utilisateur'];
                $_SESSION['role'] = $utilisateur['role'];
                if (!empty($_POST['remember'])) {
                    setcookie('user_id', $utilisateur['utilisateur'], time() + (86400 * 30), '/');
                }
                header('Location: acceuil.php');
                exit;
            } else {
                $message = 'Mot de passe incorrect.';
            }
            $utilisateurTrouve = true;
            break;
        }
    }
    if (!$utilisateurTrouve) {
        $message = 'Utilisateur non trouvé.';
    }
}
?>