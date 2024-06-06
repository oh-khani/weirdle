<?php
require_once '../assets/header.php';

if (!isset($_SESSION['user'])) {
    // Redirection si l'utilisateur n'est pas connecté
    header('Location: connexion.php');
    exit; // Arrête l'exécution du script après la redirection
}

// Récupération de l'idUtilisateur de l'utilisateur connecté
$idUtilisateur = $_SESSION['user']['idUtilisateur'];

// Traitement du formulaire de personnalisation si soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification de l'action "Par défaut"
    if (isset($_POST['default'])) {
        // Suppression des données de personnalisation pour l'utilisateur actuel
        $query = "DELETE FROM weirdle_personnalisation WHERE idUtilisateur = :idUtilisateur";
        $stmt = dbExecute($query, ['idUtilisateur' => $idUtilisateur]);
        if ($stmt) {
            // Redirection vers la page de personnalisation
            header('Location: personnalisation.php');
            exit;
        } else {
            // En cas d'erreur, affichage d'un message
            $message = "Erreur lors de la réinitialisation des préférences.";
        }
    } else {
        // Traitement de la modification de personnalisation
        $couleur = $_POST['couleur'] ?? '';
        $couleur_texte = $_POST['couleur_texte'] ?? '';
        $police_texte = $_POST['police_texte'] ?? '';

        // Mise à jour ou insertion des données de personnalisation
        $query = "INSERT INTO weirdle_personnalisation (idUtilisateur, couleur, couleur_texte, police_texte)
                  VALUES (:idUtilisateur, :couleur, :couleur_texte, :police_texte)
                  ON DUPLICATE KEY UPDATE
                  couleur = VALUES(couleur), couleur_texte = VALUES(couleur_texte), police_texte = VALUES(police_texte)";
        $params = [
            'idUtilisateur' => $idUtilisateur,
            'couleur' => $couleur,
            'couleur_texte' => $couleur_texte,
            'police_texte' => $police_texte
        ];
        $stmt = dbExecute($query, $params);
        if ($stmt) {
            $message = "Préférences enregistrées avec succès.";
        } else {
            $message = "Erreur lors de l'enregistrement des préférences.";
        }
    }
}

// Récupération des données de personnalisation de l'utilisateur actuel
$query = "SELECT * FROM weirdle_personnalisation WHERE idUtilisateur = :idUtilisateur";
$stmt = dbQuery($query, ['idUtilisateur' => $idUtilisateur]);
$personnalisation = $stmt->fetch();

// Définition des valeurs par défaut si aucune personnalisation n'est définie
$default_couleur = '#FFFFFF';
$default_couleur_texte = '#000000';
$default_police_texte = 'Arial, sans-serif';

// Utilisation des valeurs de personnalisation s'il y en a
$couleur = $personnalisation['couleur'] ?? $default_couleur;
$couleur_texte = $personnalisation['couleur_texte'] ?? $default_couleur_texte;
$police_texte = $personnalisation['police_texte'] ?? $default_police_texte;

?>

<h1>Personnalisation</h1>

<?php if (isset($message)) : ?>
    <div><?= $message ?></div>
<?php endif; ?>

<form method="post" action="personnalisation.php">
    <label for="couleur">Couleur de fond :</label>
    <input type="color" name="couleur" id="couleur" value="<?= $couleur ?>">

    <label for="couleur_texte">Couleur du texte :</label>
    <input type="color" name="couleur_texte" id="couleur_texte" value="<?= $couleur_texte ?>">

    <label for="police_texte">Police du texte :</label>
    <select name="police_texte" id="police_texte">
        <option value="Arial, sans-serif" <?= ($police_texte === 'Arial, sans-serif') ? 'selected' : '' ?>>Arial</option>
        <option value="Verdana, sans-serif" <?= ($police_texte === 'Verdana, sans-serif') ? 'selected' : '' ?>>Verdana</option>
        <option value="Times New Roman, serif" <?= ($police_texte === 'Times New Roman, serif') ? 'selected' : '' ?>>Times New Roman</option>
        <option value="Georgia, serif" <?= ($police_texte === 'Georgia, serif') ? 'selected' : '' ?>>Georgia</option>
        <option value="Courier New, monospace" <?= ($police_texte === 'Courier New, monospace') ? 'selected' : '' ?>>Courier New</option>
        <option value="Impact, sans-serif" <?= ($police_texte === 'Impact, sans-serif') ? 'selected' : '' ?>>Impact</option>
        <option value="Tahoma, sans-serif" <?= ($police_texte === 'Tahoma, sans-serif') ? 'selected' : '' ?>>Tahoma</option>
        <option value="Trebuchet MS, sans-serif" <?= ($police_texte === 'Trebuchet MS, sans-serif') ? 'selected' : '' ?>>Trebuchet MS</option>
    </select>

<button type="submit">Enregistrer</button>
<button type="submit" name="default">Par défaut</button>
</form>

<?php require_once '../assets/footer.php'; ?>