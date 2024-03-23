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
        if ($_SERVER['REQUEST_URI'] === "/weirdle/src/pages/$url") {
            $active = 'class="active"';
        } 
        echo "<li><a href=/weirdle/src/pages/$url $active>$title</a></li>";
    } ?>
    </ul>

    <ul class="navbar-right">
        <?php if (isset($_SESSION['user'])) {
            echo '<li><a href="/weirdle/src/pages/connexion.php">Déconnexion</a></li>';
        } else { 
            echo '<li><a href="/weirdle/src/pages/connexion.php">Connexion</a></li>';
        } ?>
    </ul>
</nav>