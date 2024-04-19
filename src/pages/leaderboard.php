<?php
require_once '../assets/header.php';

echo '<h1>Leaderboard</h1>';

$query = 'SELECT * FROM Weirdle_ModeJeu';
$stmt = dbQuery($query);
$modeJeux = $stmt->fetchAll();
?>
<form action="leaderboard.php" method="get">
    <select name="mode">
        <option value="0">Tous les modes</option>
        <?php foreach ($modeJeux as $modeJeu) : ?>
            <option value="<?= $modeJeu['idMode'] ?>"><?= $modeJeu['modeJeu'] ?></option>
        <?php endforeach; ?>      
    </select>
    <input type="submit" value="Valider">
</form>
<?php
if (!isset($_GET['mode']) || ($_GET['mode'] == 0)) {
    echo '<h2>Leaderboard de tous les modes</h2>';
    $scores = getLeaderBoard();
} else {    
    $query = 'SELECT modeJeu FROM Weirdle_ModeJeu WHERE idMode = :idMode';
    $stmt = dbQuery($query, ['idMode' => $_GET['mode']]);
    $modeJeu = $stmt->fetch();
    if ($modeJeu) {
        echo '<h2>Leaderboard du mode de jeu ' . $modeJeu['modeJeu'] . '</h2>';
        $scores = getLeaderBoard($_GET['mode']);
    } else {
        echo '<h2>Mode de jeu inconnu</h2>';
        $scores = getLeaderBoard();
    }
}

?>
<table>
    <thead>
        <tr>
            <th>Position</th>
            <th>Pseudo</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($scores as $score) : ?>
            <tr>
                <td><?= array_search($score, $scores) + 1 ?></td>
                <td><?= $score['pseudo'] ?></td>
                <td><?= $score['score'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require_once '../assets/footer.php';