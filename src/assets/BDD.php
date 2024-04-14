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
    $query = 'SELECT score FROM Weirdle_Score WHERE idUtilisateur = :idUtilisateur AND modeJeu = :modeJeu';
    $stmt = dbQuery($query, ['idUtilisateur' => $idUtilisateur, 'modeJeu' => $modeJeu]);
    $score = $stmt->fetch();
    return $score['score'];
}

/**
 * Fonction de récupération du leaderboard
 * @param int $modeJeu Identifiant du mode de jeu
 * @return array Tableau contenant les scores et pseudos des joueurs
 */
function getLeaderBoard($modeJeu = 0){
    $top = 10;
    if($modeJeu == 0){
        $query = "SELECT pseudo, score FROM Weirdle_Score JOIN Weirdle_Utilisateur ON Weirdle_Score.idUtilisateur = Weirdle_Utilisateur.idUtilisateur ORDER BY score DESC LIMIT $top";
    }else{
        $query = "SELECT pseudo, score FROM Weirdle_Score JOIN Weirdle_Utilisateur ON Weirdle_Score.idUtilisateur = Weirdle_Utilisateur.idUtilisateur  WHERE modeJeu = :modeJeu ORDER BY score DESC LIMIT $top";
    }
    $stmt = dbQuery($query, ['modeJeu' => $modeJeu]);
    $leaderBoard = $stmt->fetchAll();
    return $leaderBoard;
}


/**
 * Fonction de mise à jour du score
 * @param int $idUtilisateur Identifiant de l'utilisateur
 * @param int $modeJeu Identifiant du mode de jeu
 */
function updateScore($idUtilisateur, $modeJeu){
    $query = 'UPDATE Weirdle_Score SET score = score + 1 WHERE idUtilisateur = :idUtilisateur AND modeJeu = :modeJeu';
    $stmt = dbQuery($query, ['idUtilisateur' => $idUtilisateur, 'modeJeu' => $modeJeu]);
    return $stmt;
}

/**
 * Fonction d'affichage de message
 * @param string $msg Message à afficher
 * @param bool $niv Niveau de message (true = erreur, false = succès)
 */
function Message($msg, $niv){
    if($niv == true){
        echo '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
    }else{
        echo '<div class="alert alert-success" role="alert">'.$msg.'</div>';
    }
}
