<?php
session_start();

include 'scripts/functions.php';

parametres();
entete();
navigation();
$annoncesFile = 'data/annonces.json';
$annonces = json_decode(file_get_contents($annoncesFile), true) ?? [];
setlocale(LC_TIME, 'fr_FR.UTF-8');

// si il est est pas co on sort
if (!isset($_SESSION['id'])) {
    echo '<p class="text-center text-danger">Vous devez être connecté pour accéder au calendrier.</p>';
    exit;
}

// Filtrage
$covoiturages = array_filter($annonces, function ($annonce) {
    return isset($annonce['Inscrits']) && in_array($_SESSION['id'], $annonce['Inscrits']);
});

// Groupage
$covoituragesParDate = [];
foreach ($covoiturages as $covoiturage) {
    $date = explode('T', $covoiturage['Date'])[0];
    if (!isset($covoituragesParDate[$date])) {
        $covoituragesParDate[$date] = [];
    }
    $covoituragesParDate[$date][] = $covoiturage;
}
$mois = isset($_GET['mois']) ? (int)$_GET['mois'] : date('m');
$annee = isset($_GET['annee']) ? (int)$_GET['annee'] : date('Y');
if ($mois < 1) {
    $mois = 12;
    $annee--;
}
if ($mois > 12) {
    $mois = 1;
    $annee++;
}
$premierJour = date('N', strtotime("$annee-$mois-01"));
$joursDansMois = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);
?>

<body>
    <h1 class="text-center my-4">Calendrier des covoiturages</h1>

    <div class="alert alert-info text-center" role="alert">
    Salut <strong><?= htmlspecialchars($_SESSION['id']); ?></strong> ! Ce calendrier est là pour toi : il affiche uniquement les covoiturages auxquels tu es inscrit. Prêt à organiser tes trajets ? 🚗💨
    </div>
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <a href="?mois=<?= $mois === 1 ? 12 : $mois - 1 ?>&annee=<?= $mois === 1 ? $annee - 1 : $annee ?>" class="btn btn-primary">Mois précédent</a>
            <?php
            $date = new DateTime("$annee-$mois-01");
            $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
            $formatter->setPattern('MMMM yyyy');
            ?>
            <h2><?= ucfirst($formatter->format($date)) ?></h2>
            <a href="?mois=<?= $mois === 12 ? 1 : $mois + 1 ?>&annee=<?= $mois === 12 ? $annee + 1 : $annee ?>" class="btn btn-primary">Mois suivant</a>
        </div>
        <table class="table table-bordered calendar">
            <thead>
                <tr>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                    <th>Dimanche</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $jour = 1;
                for ($ligne = 0; $ligne < 6; $ligne++): ?>
                    <tr>
                        <?php for ($colonne = 1; $colonne <= 7; $colonne++): ?>
                            <td>
                                <?php
                                if (($ligne === 0 && $colonne >= $premierJour) || ($ligne > 0 && $jour <= $joursDansMois)) {
                                    $dateActuelle = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);
                                    echo '<div class="date">' . $jour . '</div>';
                                    if (isset($covoituragesParDate[$dateActuelle])) {
                                        foreach ($covoituragesParDate[$dateActuelle] as $covoiturage) {
                                            echo '<div class="event">';
                                            echo '<strong>' . htmlspecialchars($covoiturage['Depart']) . ' → ' . htmlspecialchars($covoiturage['Arrivee']) . '</strong><br>';
                                            echo 'Heure : ' . htmlspecialchars(explode('T', $covoiturage['Date'])[1]) . '<br>';
                                            echo 'Places : ' . htmlspecialchars($covoiturage['Places']);
                                            echo '</div>';
                                        }
                                    }
                                    $jour++;
                                }
                                ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</body>
</html>