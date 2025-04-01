<?php


function parametres(){
    
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
        
    
        <script src="scripts"></script>

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



function entete(){
    if (empty($_SESSION['id'])){
        echo '
        <header class="py-3 mb-4 border-bottom">
            <div class="container d-flex flex-wrap justify-content-center">
            
            <img src="images/logo.png" alt="logo" height="30px" width="30px">
            <a href="/" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                <span class="fs-3 gloria-hallelujah-regular">CarCarBla</span>
            </a>
            
            
            </div>
            <ul class="nav">
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Login</a></li>
                <li class="nav-item"><a href="#" class="nav-link link-dark px-2">Sign up</a></li>
            </ul>

        </header>
        </head>
        ';
    
    }
    else{


    }
    }
   


function navigation(){

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

function pieddepage() {
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