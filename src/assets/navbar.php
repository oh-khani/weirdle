<nav>
    <?php 
    $pages = [
        'liste.php' => 'Liste des mots',
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
</nav>