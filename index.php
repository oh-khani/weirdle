<header class="site-header">
<?php 
require_once 'src/assets/header.php';
?>
</header>
<head>
    <style>
        /* Votre CSS pour l'écran d'accueil */
        .site-header {
            visibility: hidden;
            position: fixed; /* Fixe le header en haut de la page */
            top: 0; /* Positionne le header en haut de la page */
            left: 0; /* Alignement à gauche */
            width: 100%; /* Largeur pleine de la page */
            padding: 20px; /* Espacement interne */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombre */
            z-index: 1000; /* Pour s'assurer que le header est au-dessus du contenu */
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('background.jpg'); /* Ajoutez votre image de fond */
            background-size: cover;
        }

        .title {
            font-size: 6rem;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Ajoutez une ombre au texte */
            margin-bottom: 50px;
        }

        .buttons {
            display: flex;
            gap: 20px;
        }

        .button {
            padding: 15px 40px;
            font-size: 1.5rem;
            text-transform: uppercase;
            text-decoration: none;
            color: white;
            background-color: #4cd62b;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #3ab11f;
        }
        
    </style>
</head>

<div class="container">
    <h1 class="title">Weirdle</h1>
    <div class="button-container" style="display: flex; justify-content: center;">
        <a href="LeGame.php" class="play-button">Jouer</a>
    </div>
    <div class="button-container" style="display: flex; justify-content: center;">
        <a href="src/pages/connexion.php" class="login-button">Connexion</a>
    </div>
    <div class="button-container" style="display: flex; justify-content: center;">
        <a href="src/pages/liste.php" class="login-button">Liste des mots</a>
    </div>
    <div class="button-container" style="display: flex; justify-content: center;">
        <a href="src/pages/leaderboard.php" class="login-button">Leaderboard</a>
    </div>
    <div class="button-container" style="display: flex; justify-content: center;">
        <a href="src/pages/liste_users.php" class="login-button">Utilisateurs</a>
    </div>
</div>

<?php
require_once 'src/assets/footer.php';
?>