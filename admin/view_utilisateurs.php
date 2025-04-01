<?php
session_start();
$utilisateurs = json_decode(file_get_contents('../data/utilisateurs.json'), true);
include 'scripts/functions.php';

parametres();
entete();
navigation();
?>
<body>
    <h1>Liste des Utilisateurs</h1>
    <pre>
        <?php print_r($utilisateurs); ?>
    </pre>
    
</body>
</html>
