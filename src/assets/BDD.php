<?php
require_once 'env.php';

/**
 * Fonction de connexion à la base de données
 */
function dbConnect() {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST  . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo 'Erreur de connexion : ' . $e->getMessage();
        return false;
    }
}

/**
 * Fonction de requête à la base de données
 */
function dbQuery($query, $params = []) {
    $pdo = dbConnect();
    if ($pdo === false) {
        return false;
    }
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Fonction d'exécution d'une requête à la base de données
 */
function dbExecute($query, $params = []) {
    $pdo = dbConnect();
    if ($pdo === false) {
        return false;
    }
    $stmt = $pdo->prepare($query);
    return $stmt->execute($params);
}


/**
 * Fonction d'insertion à la base de données
 */
function dbInsert($query, $params = []) {
    $pdo = dbConnect();
    if ($pdo === false) {
        return false;
    }
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $pdo->lastInsertId();
}
//////////////////////////////////////////


/**
 * Fonction de récupération de l'utilisateur
 * @param string $pseudo Pseudo de l'utilisateur
 * @return array Tableau contenant les informations de l'utilisateur
 */
function getScore($idUtilisateur, $modeJeu){
    $query = 'SELECT score FROM weirdle_score WHERE idUtilisateur = :idUtilisateur AND modeJeu = :modeJeu';
    $stmt = dbQuery($query, ['idUtilisateur' => $idUtilisateur, 'modeJeu' => $modeJeu]);
    $score = $stmt->fetch();
    return $score['score'];
}

/**
 * Fonction de mise à jour du score
 * @param int $idUtilisateur Identifiant de l'utilisateur
 * @param int $modeJeu Identifiant du mode de jeu
 * @param int $i combien il faut augmenter le score (par defaut à 1)
 */
function updateScore($idUtilisateur, $modeJeu, $i = 1){
    $query = "UPDATE weirdle_score SET score = score + $i WHERE idUtilisateur = :idUtilisateur AND modeJeu = :modeJeu";
    return dbQuery($query, ['idUtilisateur' => $idUtilisateur, 'modeJeu' => $modeJeu]);
}

/**
 * Fonction d'affichage de message
 * @param string $msg Message à afficher
 * @param bool $niv Niveau de message (true = erreur, false = succès)
 */
function Message($msg, $niv){
    if($niv){
        echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
    }else{
        echo '<div class="alert alert-success" role="alert">'.$msg.'</div>';
    }
}
