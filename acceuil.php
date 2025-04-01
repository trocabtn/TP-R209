<?php
session_start();
include 'scripts/functions.php';

$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true) ?? [];
$annonces = json_decode(file_get_contents('data/annonces.json'), true) ?? [];

parametres();
entete();
navigation();
?>

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
                    <p>Observez vos dates de trajet via notre calendrier et trouvez rapidement une annonce qui vous convient.</p>
                </div>
            </div>
        </div>

        <div class="row text-center my-4">
            <div class="col-12">
                <div class="card shadow-sm p-3 animate__animated animate__fadeInUp">
                    <h5 class="card-title">En savoir plus</h5>
                    <p>Découvrez notre <a href="wiki.php" class="text-primary">page wiki</a> pour en savoir plus sur notre fonctionnement et nos services.</p>
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

    
    <script>
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
