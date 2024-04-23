<nav>
    <?php 
    function Active($url) {
        if ($_SERVER['REQUEST_URI'] === "/~p2301285/weirdle/src/pages/$url") {
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
        'liste.php' => 'Liste des mots',
        'leaderboard.php' => 'leaderboard',
        /*
        'lien.php dans le dossier pages' => 'Nom de la page'
        */
    ];

    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 1) {
        $pages['admin.php'] = 'Admin';
    }
    
    echo '<ul>';
     
    foreach ($pages as $url => $title) {
        $active = Active($url);
        echo "<li><a href=/~p2301285/weirdle/src/pages/$url $active>$title</a></li>";
    } ?>
    </ul>

    <ul class="navbar-right">
        <?php
        if (isset($_SESSION['user'])) {
            $active = Active('profil.php');
            echo "<li><a href='/~p2301285/weirdle/src/pages/profil.php' $active>".strtoupper($_SESSION['user']['pseudo'])."$notif</a></li>";
            echo "<li><a href='/~p2301285/weirdle/src/pages/deconnexion.php'>Déconnexion</a></li>";
        } else {
            $active = Active('inscription.php');
            echo "<li><a href='/~p2301285/weirdle/src/pages/inscription.php' $active>Inscription</a></li>";
            $active = Active('connexion.php');
            echo "<li><a href='/~p2301285/weirdle/src/pages/connexion.php' $active>Connexion</a></li>";
        }
        ?>
    </ul>
</nav>