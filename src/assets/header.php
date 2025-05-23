<?php
session_start();
require_once 'BDD.php';
require_once 'functions.php';

// Récupérer les préférences de personnalisation de l'utilisateur connecté depuis la base de données
$preferences = getUserPreferences(); // Fonction à définir dans functions.php
$customStyles = '';
if ($preferences) {
    $customStyles .= 'html,body { background: ' . $preferences['couleur'] . '; }';
    $customStyles .= 'html,body { color: ' . $preferences['couleur_texte'] . '; }';
    $customStyles .= 'html,body { font-family: ' . $preferences['police_texte'] . '; }';
}

// Determine style path
if ($_SERVER['REQUEST_URI'] === "/") {
    $style = "src/style.css";
} else {
    $style = "../style.css";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Pour la police de Weirdle -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href=<?= $style; ?>>

    <title>Weirdle</title>
</head>
<body>

    <nav class="navbar">
        <div class="navbar-left">
            <?php

            function Active($url) {
                if ($_SERVER['REQUEST_URI'] === "/src/pages/$url") {
                    return 'class="active"';
                } else {
                    return '';
                }
            }
            $notif = "";
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] != 3) {
                $query = "SELECT COUNT(*) FROM `weirdle_demande`";
                $stmt = dbQuery($query);
                $demandes = $stmt->fetch()['COUNT(*)'];
                $notif = ($demandes > 0) ? " ($demandes)" : "";
            }
            $pages = [
                'liste_mots.php' => 'Liste des mots',
                'leaderboard.php' => 'Leaderboard',
                'liste_users.php' => 'Utilisateurs',
            ];
            if (isset($_SESSION['user'])) {
                $pages['personnalisation.php'] = 'Personnalisation';
            }
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 1) {
                $pages['admin.php'] = 'Admin';
            }

            echo '<ul>';

            foreach ($pages as $url => $title) {
                $active = '';
                if ($_SERVER['REQUEST_URI'] === "/src/pages/$url") {
                    $active = 'class="active"';
                }
                echo "<li><a draggable='false' href=/src/pages/$url $active>$title</a></li>";
            } ?>
            </ul>
        </div>

        <div class="navbar-center">
            <a draggable='false' id="titre" href="/weirdle.php"><h1 class="dm-sans-titre">Weirdle</h1></a>
        </div>


        <ul class="navbar-right">
        <?php
        if (isset($_SESSION['user'])) {
            $active = Active('profil.php');
            echo "<li><a draggable='false' href='/src/pages/profil.php' $active>".strtoupper($_SESSION['user']['pseudo'])."$notif</a></li>";
            echo "<li><a draggable='false' href='/src/pages/deconnexion.php'>Déconnexion</a></li>";
        } else {
            $active = Active('inscription.php');
            echo "<li><a draggable='false' href='/src/pages/inscription.php' $active>Inscription</a></li>";
            $active = Active('connexion.php');
            echo "<li><a draggable='false'href='/src/pages/connexion.php' $active>Connexion</a></li>";
        }
        ?>
    </ul>
        </div>

    </nav>
