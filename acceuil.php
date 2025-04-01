<?php
session_start();
include 'scripts/functions.php';


// Charger les données nécessaires
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true) ?? [];
$annonces = json_decode(file_get_contents('data/annonces.json'), true) ?? [];

parametres();
entete();
navigation();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - CarCarBla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(to right, #f8f9fa, #e9ecef); /* Dégradé clair */
            color: #343a40; /* Texte gris foncé */
        }
        .navbar {
            background-color: #ffffff; /* Blanc */
            border-bottom: 1px solid #dee2e6; /* Ligne de séparation */
        }
        .navbar .nav-link {
            color: #343a40; /* Gris foncé */
        }
        .navbar .nav-link:hover {
            color: #007bff; /* Bleu clair */
        }
        .card {
            background: #ffffff; /* Blanc */
            border: 1px solid #dee2e6;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .admin-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        .features {
            margin-top: 50px;
        }
        .features .feature-card {
            height: 175px; /* Hauteur fixe pour toutes les cartes */
            transition: transform 0.3s ease-in-out;
        }
        .features .feature-card:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <h1 class="text-center my-4 animate__animated animate__fadeInDown">Bienvenue chez <span style="color: #007bff;">CarCarBla</span> !</h1>

    <div class="container">
        <div class="row text-center my-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-3 animate__animated animate__zoomIn">
                    <h5 class="card-title">Nombre d'utilisateurs</h5>
                    <p class="display-6"><?= count($utilisateurs); ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm p-3 animate__animated animate__zoomIn" style="animation-delay: 0.2s;">
                    <h5 class="card-title">Nombre d'annonces</h5>
                    <p class="display-6"><?= count($annonces); ?></p>
                </div>
            </div>
        </div>

        <div class="features row text-center">
            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-3 animate__animated animate__fadeInUp">
                    <h5 class="card-title">Réservez facilement</h5>
                    <p>Planifiez vos trajets en quelques clics grâce à notre interface intuitive.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-3 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <h5 class="card-title">Conduisez en toute sécurité</h5>
                    <p>Nos conducteurs sont vérifiés pour garantir votre sécurité.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card feature-card shadow-sm p-3 animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <h5 class="card-title">Gagnez du temps</h5>
                    <p>Optimisez vos trajets avec nos itinéraires intelligents.</p>
                </div>
            </div>
        </div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="row text-center my-4 admin-section animate__animated animate__fadeInUp">
                <div class="col-12">
                    <h5 class="card-title">Administration</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="admin/view_utilisateurs.php" class="btn btn-primary animate__animated animate__pulse animate__infinite">Voir les utilisateurs</a>
                        <a href="admin/view_annonces.php" class="btn btn-primary animate__animated animate__pulse animate__infinite" style="animation-delay: 0.2s;">Voir les annonces</a>
                        <a href="administration.php" class="btn btn-primary animate__animated animate__pulse animate__infinite" style="animation-delay: 0.4s;">Page d'administration</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php pieddepage(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au survol des cartes
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseover', () => {
                card.classList.add('animate__pulse');
            });
            card.addEventListener('mouseout', () => {
                card.classList.remove('animate__pulse');
            });
        });
    </script>
</body>
</html>
