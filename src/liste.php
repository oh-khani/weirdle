<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Liste Mots</title>
</head>
<body>
    <h1>Liste des mots</h1>
    <ul>
        <?php
        $path = __DIR__ . '/Dico/dictionnaire.json';
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        $mots = $data['mots'];
        
        foreach ($mots as $mot) {
            echo "<li>$mot</li>";
        }
        ?>
    </ul>
</body>
</html>