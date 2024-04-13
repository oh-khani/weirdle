<?php
require_once '../assets/header.php';
require_once '../assets/navbar.php';
require_once '../assets/BDD.php';

if (isset($_SESSION['user'])) {
    $message = 'Vous êtes déjà connecté en tant que ' . $_SESSION['user']['pseudo'];
    $error = false;
}
if (isset($_POST['pseudo']) && isset($_POST['password'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $query = 'SELECT * FROM Weirdle_Utilisateur WHERE pseudo = :pseudo';
    $stmt = dbQuery($query, ['pseudo' => $pseudo]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        echo "<script>window.location.replace('./profil.php');</script>";
    } else {
        $message = 'Pseudo ou mot de passe incorrect';
        $error = true;
    }
}
?>
<h1>Connexion</h1>
<form method="post" action="./connexion.php">
    <div>
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
    </div>
    <button type="submit">Se connecter</button>
</form>
<?php 

if (isset($message) && isset($error)) Message($message, $error);
require_once '../assets/footer.php';
?>