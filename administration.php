<?php
session_start();
$utilisateurs = json_decode(file_get_contents('../data/utilisateurs.json'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($utilisateurs as &$user) {
        if ($user['email'] === $_POST['email']) {
            if (isset($_POST['delete'])) {
                $utilisateurs = array_filter($utilisateurs, fn($u) => $u['email'] !== $_POST['email']);
            } elseif (isset($_POST['role'])) {
                $user['role'] = $_POST['role'];
            }
        }
    }
    file_put_contents('../data/utilisateurs.json', json_encode($utilisateurs, JSON_PRETTY_PRINT));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Administration</title>
</head>
<body>
    <h1>Gestion des Utilisateurs</h1>
    <table border="1">
        <tr><th>Pseudo</th><th>Email</th><th>Rôle</th><th>Actions</th></tr>
        <?php foreach ($utilisateurs as $user) : ?>
            <tr>
                <td><?= htmlspecialchars($user['pseudo']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role'] ?? 'Utilisateur') ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                        <select name="role">
                            <option value="admin">Admin</option>
                            <option value="user">Utilisateur</option>
                        </select>
                        <button type="submit">Modifier</button>
                        <button type="submit" name="delete">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="../accueil.php">Retour à l'accueil</a>
</body>
</html>
