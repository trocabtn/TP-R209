<?php
// filepath: c:\wamp64\www\TP-R209\visualiser.php
session_start();

include 'scripts/functions.php';

parametres();
entete();
navigation();

// Charger les annonces depuis un fichier JSON
$annonces = json_decode(file_get_contents('data/annonces.json'), true);

?>

<body>
    <h1 class="text-center my-4">Liste des annonces de covoiturage</h1>

    <div class="container">
        <?php if (!empty($annonces)): ?>
            <div class="row">
                <?php foreach ($annonces as $annonce): ?>
                    <?php
                    // Extraire les données de l'annonce avec des valeurs par défaut si elles sont manquantes
                    $pseudo = htmlspecialchars($annonce['Pseudo'] ?? 'Non spécifié');
                    $date = htmlspecialchars(date('d/m/Y', strtotime($annonce['Date'] ?? '')));
                    $heure = htmlspecialchars(date('H:i', strtotime($annonce['Date'] ?? '')));
                    $depart = htmlspecialchars($annonce['Depart'] ?? 'Non spécifié');
                    $arrivee = htmlspecialchars($annonce['Arrivee'] ?? 'Non spécifié');
                    $places = htmlspecialchars($annonce['Places'] ?? 'Non spécifié');
                    $commentaire = htmlspecialchars($annonce['Commentaire'] ?? 'Aucun commentaire');
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Départ : <?= $depart ?> → <?= $arrivee ?></h5>
                                <p class="card-text">
                                    <strong>Conducteur :</strong> <?= $pseudo ?><br>
                                    <strong>Date :</strong> <?= $date ?><br>
                                    <strong>Heure :</strong> <?= $heure ?><br>
                                    <strong>Places disponibles :</strong> <?= $places ?><br>
                                    <strong>Commentaire :</strong> <?= $commentaire ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-center">Aucune annonce disponible pour le moment.</p>
        <?php endif; ?>
    </div>

    <?php pieddepage(); ?>
</body>
</html>