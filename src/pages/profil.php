<?php
require_once '../assets/header.php';
require_once '../assets/navbar.php';
require_once '../assets/BDD.php';

if (!isset($_SESSION['user'])) header('Location: connexion.php'); // Redirection si non connecté

//Récupération et affichage des informations de l'utilisateur
$query = 'SELECT * FROM Weirdle_score WHERE idUtilisateur = :idUtilisateur';
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

// Formulaire pour ajouter  ou proposer un mot
if ($_SESSION['user']['role'] != 3) { ?>
    <h2>Ajouter un mot</h2>
<?php }else{ ?>
    <h2>Proposer un mot</h2>
<?php } ?>
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
                if ($_SESSION['user']['role'] != 3) {
                    $query = 'INSERT INTO weirdle_mot (mot) VALUES (:mot)';
                    $stmt = dbInsert($query, ['mot' => $_POST['mot']]);
                } else {
                    $query = 'INSERT INTO weirdle_demande (mot, idUtilisateur) VALUES (:mot, :idUtilisateur)';
                    $stmt = dbInsert($query, ['mot' => $_POST['mot'], 'idUtilisateur' => strtoupper($_SESSION['user']['idUtilisateur'])]);
                }
                Message('Mot ajouté', false);
            }
        }
    }
}
//////////////////////////////////////////

// Affichage des mots demandés si l'utilisateur est admin
if ($_SESSION['user']['role'] == 1) {
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
    }
    //////////////////////////////////////////
    $query = 'SELECT * FROM weirdle_demande';
    $stmt = dbQuery($query);
    $mots = $stmt->fetchAll();
    
    echo "<h2>Mots demandés</h2>";
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
                    $pseudo = $stmt->fetch()['pseudo']; ?>
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
