<?php
    require_once '../assets/header.php';
?>

<?php
    // Lire le fichier JSON
    $json_file = file_get_contents(__DIR__ . '/../Dico/dictionnaire.json');

    if ($json_file === false) {
        die('Erreur lors de la lecture du fichier JSON');
    }

    $words_array = json_decode($json_file, true);

    if ($words_array === null) {
        die('Erreur lors du décodage du fichier JSON');
    }

    $mots = $words_array['mots'];
    sort($mots);

    $nombreColonnes = 15;
    $nbMots = count($mots);
    $nombreLignes = ceil($nbMots / $nombreColonnes);

    echo "<table>";

    for ($i = 0; $i < $nombreLignes; $i++) {
        echo "<tr>";
        for ($j = 0; $j < $nombreColonnes; $j++) {
            $indexMot = $i * $nombreColonnes + $j;
            if ($indexMot < $nbMots) {
                echo "<td>" . htmlspecialchars($mots[$indexMot]) . "</td>";
            } else {
                echo "<td></td>"; // Cellule vide si plus de mots
            }
        }
        echo "</tr>";
    }

    echo "</table>";
?>

<?php require_once '../assets/footer.php'; ?>
