<nav>
    <?php 
    $pages = [
        'liste.php' => 'Liste des mots',
        /*
        'lien.php dans le dossier pages' => 'Nom de la page',
        Sauf connexion.php
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
        $active = ($_SERVER['REQUEST_URI'] === "/~p2301285/weirdle/src/pages/connexion.php")? "class='active'"  : '' ;
        
        if (isset($_SESSION['user'])) {
            echo "<li><a href='/~p2301285/weirdle/src/pages/connexion.php' $active>Déconnexion</a></li>";
        } else { 
            echo "<li><a href='/~p2301285/weirdle/src/pages/connexion.php' $active>Connexion</a></li>";
        } ?>
    </ul>
</nav>