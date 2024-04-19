<?php
    require_once '../assets/header.php';
?>
    <h1>Liste des mots</h1>
    <ul>
        <?php
        $path = '../Dico/dictionnaire.json';
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        $mots = $data['mots'];
        
        foreach ($mots as $mot) {
            echo "<li>$mot</li>";
        }
        ?>
    </ul>
<?php require_once '../assets/footer.php'; ?>