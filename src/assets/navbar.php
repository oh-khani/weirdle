<nav>
    <?php 
    $pages = [
        'liste.php' => 'Liste des mots',
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
</nav>