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



function entete($param="") {
    echo '
    <header class="py-3 mb-4 border-bottom">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="mx-auto">
                    <a href="'.$param.'acceuil.php" class="d-flex flex-column align-items-center text-dark text-decoration-none">
                        <img src="'.$param.'images/logo.png" alt="logo" height="50px" class="mb-2">
                        <span class="fs-3 gloria-hallelujah-regular">CarCarBla</span>
                    </a>
                </div>';

    if (empty($_SESSION['id'])) {
        echo '
                <div>
                    <a href="'.$param.'connexion.php" class="btn btn-primary me-2">Se connecter</a>
                    <a href="'.$param.'inscription.php" class="btn btn-outline-success">S\'inscrire</a>
                </div>';
    } else {
        echo '
                <div>
                    <a href="'.$param.'profil.php" class="btn btn-secondary me-2">Mon Profil</a>
                    <a href="'.$param.'deconnexion.php" class="btn btn-danger">Déconnexion</a>
                </div>';
    }

    echo '
            </div>
        </div>
    </header>';
}



function navigation($param=""){

        echo '
        <nav class="py-2 bg-light border-bottom">
            <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2 active" aria-current="page">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Features</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Pricing</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">FAQs</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">About</a></li>
            </ul>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0">
                <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
            </form>
            </div>
        </nav>  
        ';
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

?>