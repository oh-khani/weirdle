<nav>
    <?php 

    $pages = [
        'liste.php' => 'Liste des mots',
        /*
        'lien.php dans le dossier pages' => 'Nom de la page'
        */
    ]; 
    
    echo '<ul>';
     
    foreach ($pages as $url => $title) {
        $active = '';
        if ($_SERVER['REQUEST_URI'] === "/~p2301285/weirdle/src/pages/$url") {
            $active = 'class="active"';
        } 
        echo "<li><a href=/~p2301285/weirdle/src/pages/$url $active>$title</a></li>";
    } ?>
    </ul>

    <ul class="navbar-right">
        <?php
        if (isset($_SESSION['user'])) {
            echo "<li><a href='/~p2301285/weirdle/src/pages/profil.php'>".$_SESSION['user']['pseudo']."</a></li>";
            echo "<li><a href='/~p2301285/weirdle/src/pages/deconnexion.php'>Déconnexion</a></li>";
        } else {
            echo "<li><a href='/~p2301285/weirdle/src/pages/inscription.php'>Inscription</a></li>";
            echo "<li><a href='/~p2301285/weirdle/src/pages/connexion.php'>Connexion</a></li>";
        }
        ?>
    </ul>
</nav>