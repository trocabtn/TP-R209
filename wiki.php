<?php
session_start();
include 'scripts/functions.php';
parametres();
entete();
navigation();
?>
<body>
    <h1 class="text-center my-4">Wiki - Informations sur le projet</h1>
    <div class="container">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Liste des fonctions utilisées</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>parametres()</strong> : Initialise les paramètres globaux du site.</li>
                    <li><strong>entete()</strong> : Affiche l'en-tête du site.</li>
                    <li><strong>navigation()</strong> : Génère le menu de navigation.</li>
                    <li><strong>pieddepage()</strong> : Affiche le pied de page.</li>
                    <li><strong>json_decode()</strong> : Permet de lire les fichiers JSON pour charger les données.</li>
                    <li><strong>file_put_contents()</strong> : Sauvegarde les données dans les fichiers JSON.</li>
                </ul>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Identifiants et mots de passe pour tester le site</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Administrateur :</strong> <code>admin / motdepasse</code></li>
                    <li><strong>Modérateur :</strong> <code>modo / motdepasse</code></li>
                    <li><strong>Utilisateur :</strong> <code>user / motdepasse</code></li>
                    
                </ul>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5>Ce qui fonctionne / ne fonctionne pas</h5>
            </div>
            <div class="card-body">
                <h6>Fonctionnalités fonctionnelles :</h6>
                <ul>
                    <li>Connexion et déconnexion des utilisateurs.</li>
                    <li>Affichage des annonces disponibles.</li>
                    <li>Création, modification et suppression des annonces.</li>
                    <li>Navigation entre les pages (accueil, wiki, administration).</li>
                    <li>Afin de vérifier le fonctionnenement du calendrier vous pouvez vous rendre dans le mois de Avril en 2024.</li>  
                    <li>Gestion des rôles (admin, modo, user).</li>

                </ul>
                <h6>Fonctionnalités non fonctionnelles ou à améliorer :</h6>
                <ul>
                    <li>Gestion des erreurs pour les fichiers JSON manquants ou corrompus.</li>
                    <li>Amélioration de l'interface utilisateur pour les petits écrans.</li>
                    
                </ul>
            </div>
        </div>
    </div>
    <?php pieddepage(); ?>
</body>
</html>