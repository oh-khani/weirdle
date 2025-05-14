<header class="hide-header">
<?php
require_once 'src/assets/header.php';
?>
</header>

<head>
    <style>
        .hide-header{
            display: none;
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

        .button-container{
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        button, .button-container{
            padding: 0.5rem 2rem;
            background-color: rgb(66, 66, 66);
            border-color: #252525;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        a{
            text-decoration: none;
        }


        .button:hover {
            background-color: #3ab11f;
        }

    </style>
</head>

<div class="container">
    <h1 class="title">Weirdle</h1>
    <div class="button-container">
        <a href="weirdle.php" class="play-button">Jouer</a>
    </div>
    <div class="button-container">
        <a href="src/pages/connexion.php" class="login-button">Connexion</a>
    </div>
    <div class="button-container">
        <a href="src/pages/liste_mots.php" class="login-button">Liste des mots</a>
    </div>
    <div class="button-container">
        <a href="src/pages/leaderboard.php" class="login-button">Leaderboard</a>
    </div>
    <div class="button-container">
        <a href="src/pages/liste_users.php" class="login-button">Utilisateurs</a>
    </div>
</div>

<?php
require_once 'src/assets/footer.php';
?>
