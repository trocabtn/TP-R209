<?php
session_start();
include 'scripts/functions.php';

parametres();
entete();
navigation();
?>

<?php
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$annonces = json_decode(file_get_contents('data/annonces.json'), true);
?>

<body>
<h1 class="text-center my-4">Bienvenue chez CarCarBla !</h1>

<div class="container">
    <div class="row text-center my-4">
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Nombre d'utilisateurs</h5>
                <p class="display-6"><?= count($utilisateurs); ?></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5 class="card-title">Nombre d'annonces</h5>
                <p class="display-6"><?= count($annonces); ?></p>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="row text-center my-4">
            <div class="col-12">
                <div class="card shadow-sm p-3">
                    <h5 class="card-title">Administration</h5>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="admin/view_utilisateurs.php" class="btn btn-primary">Voir les utilisateurs</a>
                        <a href="admin/view_annonces.php" class="btn btn-primary">Voir les annonces</a>
                        <a href="administration.php" class="btn btn-primary">Page d'administration</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php pieddepage(); ?>
</body>
</html>
