<?php
require_once '../assets/header.php';
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 1) echo '<script>window.location.href = "/~p2301285/weirdle/src/pages/connexion.php";</script>';

if (isset($_POST['role']) && isset($_POST['pseudo'])) {
    $query = 'UPDATE weirdle_utilisateur SET role = :role WHERE pseudo = :pseudo';
    dbQuery($query, ['role' => $_POST['role'], 'pseudo' => $_POST['pseudo']]);
}

echo '<h1>Administation</h1>';
$query = 'SELECT pseudo, role FROM weirdle_utilisateur';
$stmt = dbQuery($query);
$users = $stmt->fetchAll();

$query = 'SELECT * FROM weirdle_role';
$stmt = dbQuery($query);
$roles = $stmt->fetchAll();
?>
<h2>Gestion des rôles</h2>
<table>
    <thead>
        <tr>
            <th>Pseudo</th>
            <th>Rôle</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user['pseudo'] ?></td>
                <?php if ($user['role'] == 1) : ?>
                    <td>Administrateur</td>
                <?php else : ?>
                    <td><form action="admin.php" method="post">
                        <select name="role">
                            <?php foreach ($roles as $role) : ?>
                                <option value="<?= $role['idRole'] ?>" <?= ($role['idRole'] == $user['role']) ? 'selected' : '' ?>><?= $role['Role'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" name="pseudo" value="<?= $user['pseudo'] ?>">
                        <input type="submit" value="Valider">
                    </form></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../assets/footer.php'; ?>