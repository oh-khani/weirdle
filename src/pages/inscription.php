<?php
require_once '../assets/header.php';

echo "<h1>Inscription</h1>";

if (isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['password2'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $query = 'SELECT * FROM Weirdle_Utilisateur WHERE pseudo = :pseudo';
    $stmt = dbQuery($query, ['pseudo' => $pseudo]);
    $user = $stmt->fetch();
    if ($user) {
        $message = 'Ce pseudo est déjà utilisé';
        $error = true;
    } else if ($password !== $password2) {
        $message = 'Les mots de passe ne correspondent pas';
        $error = true;
    } else {
        $query = "INSERT INTO Weirdle_Utilisateur (pseudo, password, role) VALUES (:pseudo, :password, 3)";
        $stmt = dbInsert($query, ['pseudo' => $pseudo, 'password' => password_hash($password, PASSWORD_DEFAULT)]);

        $query = "SELECT idUtilisateur, role FROM Weirdle_Utilisateur WHERE pseudo = :pseudo";
        $idUtilisateur = dbQuery($query, ['pseudo' => $pseudo])->fetch()['idUtilisateur'];
        $role = dbQuery($query, ['pseudo' => $pseudo])->fetch()['role'];

        $query = "SELECT idMode FROM Weirdle_ModeJeu";
        $stmt = dbQuery($query);
        $modeJeux = $stmt->fetchAll();

        foreach ($modeJeux as $modeJeu) {
            $query = "INSERT INTO Weirdle_Score (idUtilisateur, modeJeu, score) VALUES (:idUtilisateur, :idMode, 0)";
            $stmt = dbInsert($query, ['idUtilisateur' => $idUtilisateur, 'idMode' => $modeJeu['idMode']]);
        }
        $_SESSION['user'] = ['pseudo' => $pseudo, 'role' => $role, 'idUtilisateur' => $idUtilisateur, 'img' => 'default.jpg'];
        echo "<script>window.location.replace('./profil.php');</script>";
    }
}

if (!isset($_SESSION['user'])){ ?>
    <form action="inscription.php" method="post">
        <div>
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" id="pseudo" required>
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password2">Confirmer le mot de passe</label>
            <input type="password" name="password2" id="password2" required>
        </div>
        <button type="submit">S'inscrire</button>
    </form>
<?php }else {
    echo "<script>window.location.replace('./profil.php');</script>";
    }
if (isset($message) && isset($error)) Message($message, $error);
require_once '../assets/footer.php';