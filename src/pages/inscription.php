<?php
require_once '../assets/header.php';
require_once '../assets/navbar.php';
require_once '../assets/BDD.php';
?>

<h1>Inscription</h1>

<?php
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

        for ($i=1; $i <= 4; $i++) { 
            $query = "INSERT INTO Weirdle_Score (idUtilisateur, modeJeu, score) VALUES (:idUtilisateur, $i, 0)";
            $stmt2 = dbInsert($query, ['idUtilisateur' => $idUtilisateur]);
        }

        if ($stmt) {
            $_SESSION['user'] = ['pseudo' => $pseudo, 'role' => $role, 'idUtilisateur' => $idUtilisateur];
            echo "<script>window.location.replace('./profil.php');</script>";
        } else {
            $message = 'Erreur lors de l\'inscription';
            $error = true;
        }
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
    echo "<script>window.location.replace('./inscription.php');</script>";
    }
if (isset($message) && isset($error)) Message($message, $error);
require_once '../assets/footer.php';