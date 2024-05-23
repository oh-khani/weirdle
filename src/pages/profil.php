<?php
require_once '../assets/header.php';

if (!isset($_SESSION['user'])) header('Location: connexion.php'); // Redirection si non connecté

//Récupération et affichage des informations de l'utilisateur
$query = 'SELECT * FROM weirdle_score WHERE idUtilisateur = :idUtilisateur';
$stmt = dbQuery($query, ['idUtilisateur' => $_SESSION['user']['idUtilisateur']]);
$scores = $stmt->fetchAll();

$query = 'SELECT idMode, modeJeu FROM weirdle_modejeu';
$stmt = dbQuery($query);
$modeJeux = $stmt->fetchAll();

$query = 'SELECT * FROM weirdle_role';
$stmt = dbQuery($query);
$roles = $stmt->fetchAll();
$role = $roles[$_SESSION['user']['role'] - 1]['Role'];
?>

<h1>Profil de <?= strtoupper($_SESSION['user']['pseudo']) ?></h1>
<h2>Role: <?= strtoupper($role) ?></h2>
<img src="../img/profil/<?= $_SESSION['user']['img'] ?>" style="width: 100px; height: 100px;">
<h2>Score</h2>
<table>
    <thead>
        <tr>
            <th>Mode de jeu</th>
            <th>Score</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($scores as $score) { ?>
            <tr>
                <td><?= $modeJeux[$score['modeJeu'] - 1]['modeJeu'] ?></td>
                <td><?= $score['score'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
//////////////////////////////////////////

// Choisir une image de profil ///////
echo "<h2>Changer l'image de profil</h2>";
$images = glob('../img/profil/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
if (!in_array('../img/profil/'.$_SESSION['user']['img'], $images)) {
    $_SESSION['user']['img'] = 'default.jpg';
}
?>
<form method="post" action="profil.php">
    <div>
        <label for="image">Image: </label>
        <?php foreach ($images as $image) {
            $image = basename($image);
            if ($image == $_SESSION['user']['img']) {
                echo "<input type='radio' name='image' value='$image' id='$image' checked>";
            } else {
                echo "<input type='radio' name='image' value='$image' id='$image'>";
            }
            echo "<label for='$image'><img src='../img/profil/$image' alt='image' style='width: 100px; height: 100px;'></label>";
        } ?>
    </div>
    <button type="submit">Changer</button>
</form>

<?php
if (isset($_POST['image'])) {
    $query = 'UPDATE weirdle_utilisateur SET img = :img WHERE idUtilisateur = :idUtilisateur';
    $stmt = dbExecute($query, ['img' => $_POST['image'], 'idUtilisateur' => $_SESSION['user']['idUtilisateur']]);
    if ($stmt) {
        $_SESSION['user']['img'] = $_POST['image'];
        Message('Image de profil changée', false);
    } else {
        Message('Erreur lors du changement d\'image', true);
    }
}
//////////////////////////////////////////

// Reinitialisation du mot de passe///////
echo "<h2>Réinitialisation du mot de passe</h2>";
?>
<form method="post" action="profil.php">
    <div>
        <label for="reinit">Nouveau mot de passe</label>
        <input type="password" name="reinit" id="reinit" required>
    </div>
    <div>
        <label for="reinit2">Confirmer le mot de passe</label>
        <input type="password" name="reinit2" id="reinit2" required>
    </div>
    <button type="submit">Réinitialiser</button>
</form>
<?php
if (isset($_POST['reinit']) && isset($_POST['reinit2'])) {
    if ($_POST['reinit'] == $_POST['reinit2']) {
        // Au moins 5 caractères, une majuscule, une minuscule
        if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,}$/', $_POST['reinit'])) {
            $query = 'UPDATE weirdle_utilisateur SET password = :password WHERE idUtilisateur = :idUtilisateur';
            $stmt = dbExecute($query, ['password' => password_hash($_POST['reinit'], PASSWORD_DEFAULT), 'idUtilisateur' => $_SESSION['user']['idUtilisateur']]);
            if ($stmt) {
                Message('Mot de passe réinitialisé', false);
            } else {
                Message('Erreur lors de la réinitialisation', true);
            }
        } else {
            Message('Le mot de passe doit contenir au moins 5 caractères, une majuscule et un chiffre', true);
        }
    } else {
        Message('Les mots de passe ne correspondent pas', true);
    }
}
//////////////////////////////////////////

// Formulaire pour ajouter  ou proposer un mot
if ($_SESSION['user']['role'] == 1) { 
    echo "<h2>Ajouter un mot</h2>";
}else{ 
    echo "<h2>Proposer un mot</h2>";
} ?>
<form method="post" action="profil.php">
    <div>
        <label for="mot">Mot</label>
        <input type="text" name="mot" id="mot" required>
    </div>   
</form>
<?php //////////////////////////////////////////

// Ajout d'un mot dans la base de données
if (isset($_POST['mot'])) {
    if (!preg_match('/^[a-zA-Z]{5}$/', $_POST['mot'])) {
        Message('Le mot doit contenir 5 lettres', true);
    } else {
        $query = 'SELECT * FROM weirdle_mot WHERE mot = :mot';
        $stmt = dbQuery($query, ['mot' => $_POST['mot']]);
        $mot = $stmt->fetch();
        if ($mot) {
            Message('Le mot existe déjà', true);
        }else{
            $query = 'SELECT * FROM weirdle_demande WHERE mot = :mot';
            $stmt = dbQuery($query, ['mot' => $_POST['mot']]);
            $mot = $stmt->fetch();
            if ($mot) {
                Message('Le mot a déjà été proposé', true);
            }else{
                if ($_SESSION['user']['role'] == 1) {
                    $query = 'INSERT INTO weirdle_mot (mot) VALUES (:mot)';
                    $stmt = dbInsert($query, ['mot' => strtoupper($_POST['mot'])]);
                    Message('Mot ajouté', false);
                } else {
                    $query = 'INSERT INTO weirdle_demande (mot, idUtilisateur) VALUES (:mot, :idUtilisateur)';
                    $stmt = dbInsert($query, ['mot' => strtoupper($_POST['mot']), 'idUtilisateur' => $_SESSION['user']['idUtilisateur']]);
                    Message('Mot proposé', false);
                }
            }
        }
    }
}
//////////////////////////////////////////

// Affichage des mots demandés si l'utilisateur est admin
if ($_SESSION['user']['role'] != 3) {
    echo "<h2>Mots demandés</h2>";
    // Suppression et validation des mots demandés si l'utilisateur est admin
    if (isset($_POST['suppr'])) {
        $query = 'DELETE FROM weirdle_demande WHERE Mot = :mot';
        $stmt = dbExecute($query, ['mot' => $_POST['suppr']]);
        if ($stmt) {
            Message('Mot supprimé', false);
        } else {
            Message('Erreur lors de la suppression', true);
        }
    }
    if (isset($_POST['valider'])) {
        $query = 'INSERT INTO weirdle_mot (Mot) VALUES (:mot)';
        $stmt = dbInsert($query, ['mot' => $_POST['valider']]);

        $query = 'DELETE FROM weirdle_demande WHERE mot = :mot';
        $stmt = dbExecute($query, ['mot' => $_POST['valider']]);
        if ($stmt) {
            Message('Mot validé', false);
        } else {
            Message('Erreur lors de la validation', true);
        }
    }
    //////////////////////////////////////////
    $query = 'SELECT * FROM weirdle_demande';
    $stmt = dbQuery($query);
    $mots = $stmt->fetchAll();
    
    if (count($mots) == 0) {
        Message('Aucun mot demandé', false);
    }else{?>
        <table>
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Mot</th>
                    <th>Supprimer</th>
                    <th>Valider</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mots as $mot) {
                    $query = 'SELECT pseudo FROM weirdle_utilisateur WHERE idUtilisateur = :idUtilisateur';
                    $stmt = dbQuery($query, ['idUtilisateur' => $mot['idUtilisateur']]);
                    $pseudo = $stmt->fetch()['pseudo']; 
                    if (!$pseudo) $pseudo = 'Utilisateur supprimé';
                    ?>
                    <tr>
                        <td><?= $pseudo ?></td>
                        <td><?= $mot['mot'] ?></td>
                        <td>
                            <form method="post" action="profil.php">
                                <input type="hidden" name="suppr" value="<?= $mot['mot'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="profil.php">
                                <input type="hidden" name="valider" value="<?= $mot['mot'] ?>">
                                <button type="submit">Valider</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php }
}
//////////////////////////////////////////

require_once '../assets/footer.php';
