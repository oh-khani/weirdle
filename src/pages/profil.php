<?php
require_once '../assets/header.php';
require_once '../assets/navbar.php';
require_once '../assets/BDD.php';


if (!isset($_SESSION['user'])) {
    header('Location: connexion.php');
}

$query = 'SELECT * FROM Weirdle_score WHERE idUtilisateur = :idUtilisateur';
$stmt = dbQuery($query, ['idUtilisateur' => $_SESSION['user']['idUtilisateur']]);
$scores = $stmt->fetchAll();

$query = 'SELECT idMode, modeJeu FROM weirdle_modejeu';
$stmt = dbQuery($query);
$modeJeux = $stmt->fetchAll();
?>

<h1>Profil de <?= $_SESSION['user']['pseudo'] ?></h1>
<h2>Score</h2>
<table>
    <thead>
        <tr>
            <th>Mode de jeu</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($scores as $score) { ?>
            <tr>
                <td><?= $modeJeux[$score['modeJeu'] - 1]['modeJeu'] ?></td>
                <td><?= $score['score'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require_once '../assets/footer.php';
