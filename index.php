<?php 
require_once 'src/assets/header.php';
?>
    <div class="container">
        <div id="tooltip"><p>Ce mot n'est pas dans la liste</p></div>
        <div id="game"></div>
        <div id="score"></div>
        <div id="button-container"></div>
        <div id="keyboard"></div>
    </div>

    <script type="module" src="src/game/Game.js"></script>
    
<?php
require_once 'src/assets/footer.php';
?>