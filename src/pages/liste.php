<?php
    require_once '../assets/header.php';
?>

    <h1>Rechercher un mot</h1>
    <form action="liste.php" method="post">
        <input type="text" name="mot" placeholder="Mot à rechercher">
        <button type="submit">Rechercher</button>
    </form>

<?php
    if (isset($_POST['mot'])) {
        $query = 'SELECT * FROM weirdle_mot WHERE Mot = :mot';
        $stmt = dbQuery($query, ['mot' => strtoupper($_POST['mot'])]);
        $mot = $stmt->fetch();
        if ($mot) {
            Message('Mot trouvé', false);
        } else {
            Message('Mot non trouvé', true);
        }
    }
    $query = 'SELECT * FROM weirdle_mot';
    $stmt = dbQuery($query);
    $mots = $stmt->fetchAll();
?>
    <h1>Liste des mots</h1>
    <ul>
        <?php
        foreach ($mots as $mot) {
            echo '<li>' . $mot['Mot'] . '</li>';
        }
        ?>
    </ul>
<?php require_once '../assets/footer.php'; ?>