<?php
session_start();
$annonces = json_decode(file_get_contents('../data/annonces.json'), true);
include '../scripts/functions.php';

parametres('../');
entete('../');
navigation('../');
?>
<body>
    <h1>Liste des Annonces</h1>
        <pre>
            <?php print_r($annonces); ?>
        </pre>
    
</body>
</html>
