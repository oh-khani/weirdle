<?php 
require_once 'src/assets/header.php';
?>

    <div id="menu">
        <h2>Choisissez votre mode de jeu :</h2>
        <button id="mode-normal">Mode Normal</button>
        <button id="mode-chrono">Mode Chronomètre</button>
        <button id="mode-inv">Mode Invisible</button>
    </div>    

    <div id="main-container">
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