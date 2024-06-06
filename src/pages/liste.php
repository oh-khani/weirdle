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
        if (preg_match('/^[a-zA-Z]{5}$/', $_POST['mot'])) {
            $query = 'SELECT * FROM weirdle_mot WHERE Mot = :mot';
            $stmt = dbQuery($query, ['mot' => strtoupper($_POST['mot'])]);
            $mot = $stmt->fetch();
            if ($mot) {
                Message('Mot trouvé', false);
            } else {
                Message('Mot non trouvé', true);
            }
        } else {
            Message('Le mot doit contenir 5 lettres', true);
        }
    }

    // Arranger les mots dans un tableau
    $nombreColonnes = 15;

    $query = 'SELECT * FROM weirdle_mot';
    $stmt = dbQuery($query);
    $mots = $stmt->fetchAll();
    $betterResult = array_column($mots, "Mot", "idMot");

    $nbMots = count($mots);
    $nombreLignes = ceil($nbMots / $nombreColonnes);

    
    echo "<table>";
    // Boucle pour chaque ligne
    for ($i = 1; $i <= $nombreLignes; $i++) {
        echo "<tr>";
        // Boucle pour chaque colonne dans la ligne
        for ($j = 1; $j <= $nombreColonnes; $j++) {
            $indexMot = $i * $nombreColonnes + $j;
            if ($indexMot < $nbMots) {
                echo "<td>" . $betterResult[$indexMot] . "</td>";
            }
        }
        echo "</tr>";
    }

    echo "</table>";
?>

<?php require_once '../assets/footer.php'; ?>