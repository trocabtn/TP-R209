<?php
session_start();
include 'scripts/functions.php';

// Débogage temporaire pour vérifier la session
// var_dump($_SESSION);
// exit;

// Vérification si l'utilisateur est administrateur
// Vérification si l'utilisateur est administrateur


// Charger les utilisateurs depuis le fichier JSON
$utilisateurs = json_decode(file_get_contents('data/utilisateurs.json'), true);
$message = '';

// Gestion des actions (modification, suppression, recherche)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modifier_role'])) {
        $pseudo = $_POST['utilisateur'];
        $nouveau_role = $_POST['role'];
        foreach ($utilisateurs as &$utilisateur) {
            if ($utilisateur['utilisateur'] === $pseudo) {
                $utilisateur['role'] = $nouveau_role;
                $message = "Le rôle de l'utilisateur a été modifié.";
                break;
            }
        }
        file_put_contents('data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));
    }

    if (isset($_POST['supprimer_utilisateur'])) {
        $pseudo = $_POST['utilisateur'];
        $utilisateurs = array_filter($utilisateurs, function ($utilisateur) use ($pseudo) {
            return $utilisateur['utilisateur'] !== $pseudo;
        });
        $message = "L'utilisateur a été supprimé.";
        file_put_contents('data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));
    }

    if (isset($_POST['rechercher'])) {
        $recherche = $_POST['recherche'];
        $utilisateurs = array_filter($utilisateurs, function ($utilisateur) use ($recherche) {
            return stripos($utilisateur['utilisateur'], $recherche) !== false;
        });
    }
}

parametres();
entete();
?>

<body>
    <div class="container mt-5">
        <h2>Administration des utilisateurs</h2>
        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Formulaire de recherche -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="recherche" placeholder="Rechercher par nom">
                <button type="submit" name="rechercher" class="btn btn-primary">Rechercher</button>
            </div>
        </form>

        <!-- Tableau des utilisateurs -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Véhicule</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <tr>
                        <td><?php echo $utilisateur['utilisateur']; ?></td>
                        <td><?php echo $utilisateur['email']; ?></td>
                        <td><?php echo $utilisateur['vehicule']; ?></td>
                        <td><?php echo $utilisateur['role'] ?? 'utilisateur'; ?></td>
                        <td>
                            <!-- Formulaire pour modifier le rôle -->
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="utilisateur" value="<?php echo $utilisateur['utilisateur']; ?>">
                                <select name="role" class="form-select d-inline w-auto">
                                    <option value="utilisateur" <?php echo ($utilisateur['role'] ?? 'utilisateur') === 'utilisateur' ? 'selected' : ''; ?>>Utilisateur</option>
                                    <option value="admin" <?php echo ($utilisateur['role'] ?? 'utilisateur') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <button type="submit" name="modifier_role" class="btn btn-success btn-sm">Modifier</button>
                            </form>

                            <!-- Formulaire pour supprimer un utilisateur -->
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="utilisateur" value="<?php echo $utilisateur['utilisateur']; ?>">
                                <button type="submit" name="supprimer_utilisateur" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<?php
pieddepage();
?>