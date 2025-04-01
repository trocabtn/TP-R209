<?php
session_start();
include '../scripts/functions.php';

parametres('../');
entete('../');
navigation('../');
?>
<body>
    <h1>Liste des Utilisateurs</h1>
    <pre>
        <?php
        $utilisateurs = json_decode(file_get_contents('../data/utilisateurs.json'), true);
        print_r($utilisateurs);
        ?>
    </pre>
    
</body>
</html>
