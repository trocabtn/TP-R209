<?php


function parametres($param=""){
    
    // récupération du nom de la page courante
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

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <header class="py-3 mb-4 border-bottom">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center">
                <a href="' . $prefix . 'acceuil.php" class="text-dark text-decoration-none text-center">
                    <img src="' . $prefix . 'images/logo.png" alt="Logo CarCarBla" style="height: 50px; margin-right: 10px;">
                    <span class="fs-3 gloria-hallelujah-regular">CarCarBla</span>
                </a>
            </div>
        </div>
    </header>';
}



function navigation($prefix = '') {
    echo '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
    echo '<div class="container-fluid">';
    echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
    echo '<span class="navbar-toggler-icon"></span>';
    echo '</button>';
    echo '<div class="collapse navbar-collapse" id="navbarNav">';
    echo '<ul class="navbar-nav me-auto">';

    // Lien vers la page d'accueil
    echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'acceuil.php">Accueil</a></li>';

    // Lien vers le profil (uniquement si connecté)
    if (isset($_SESSION['id'])) {
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'profil.php">Profil</a></li>';
    }

    // Liens pour les administrateurs
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'admin/view_utilisateurs.php">Voir les utilisateurs</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'admin/view_annonces.php">Voir les annonces</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'administration.php">Administration</a></li>';
    }

    echo '</ul>';

    // Boutons de connexion/déconnexion et inscription
    echo '<ul class="navbar-nav">';
    if (isset($_SESSION['id'])) {
        echo '<li class="nav-item"><a class="nav-link text-danger" href="' . $prefix . 'deconnexion.php">Déconnexion</a></li>';
    } else {
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'connexion.php">Connexion</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="' . $prefix . 'inscription.php">Inscription</a></li>';
    }
    echo '</ul>';

    echo '</div>';
    echo '</div>';
    echo '</nav>';
}

function pieddepage($param="") {
    $heure = date('H:i');
    $annee = date('Y');
    $ip = $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];

    echo ' 
    <div class="container mt-5">
        <div class="jumbotron text-center py-4 bg-light border rounded">
            <p class="mb-1"><strong>Robin BATON</strong> - robin.baton@etudiant.univ-rennes.fr - G1</p>
            <p class="mb-1">' . $heure . ' &copy; ' . $annee . ' | IP: ' . $ip . ' | Port: ' . $port . '</p>
            <div class="d-flex justify-content-center mt-2">
                <a href="#" class="mx-2 text-dark">Instagram</a>
                <a href="#" class="mx-2 text-dark">LinkedIn</a>
            </div>
        </div>
    </div>';
}

function afficherLienDeconnexion($prefix = '') {
    if (isset($_SESSION['id'])) {
        echo '<a href="' . $prefix . 'deconnexion.php" class="btn btn-danger">Déconnexion</a>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Charger les utilisateurs depuis le fichier JSON
    $utilisateurs = json_decode(file_get_contents(__DIR__ . '/../data/utilisateurs.json'), true);

    // Vérifier si le fichier JSON est valide
    if (!is_array($utilisateurs)) {
        $utilisateurs = []; // Définit un tableau vide si le fichier JSON est vide ou invalide
    }

    $pseudo = $_POST['pseudo'] ?? ''; // Récupérer le pseudo depuis le formulaire
    $password = $_POST['password'] ?? ''; // Récupérer le mot de passe depuis le formulaire

    // Recherche de l'utilisateur dans le fichier JSON
    $utilisateurTrouve = false;
    foreach ($utilisateurs as $utilisateur) {
        if (isset($utilisateur['utilisateur'], $utilisateur['motdepasse'], $utilisateur['role']) &&
            $utilisateur['utilisateur'] === $pseudo) { // Vérifier le pseudo
            // Vérification du mot de passe avec le hash stocké
            if (password_verify($password, $utilisateur['motdepasse'])) {
                $_SESSION['id'] = $utilisateur['utilisateur'];
                $_SESSION['role'] = $utilisateur['role'];

                // Gestion des cookies pour l'authentification persistante (bonus)
                if (!empty($_POST['remember'])) {
                    setcookie('user_id', $utilisateur['utilisateur'], time() + (86400 * 30), '/'); // 30 jours
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