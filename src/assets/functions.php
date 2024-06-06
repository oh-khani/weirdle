<?php
require_once 'env.php';

// Fonction pour récupérer les préférences de personnalisation de l'utilisateur connecté
function getUserPreferences() {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['idUtilisateur'])) {
        global $pdo;

        
        $query = "SELECT * FROM weirdle_personnalisation WHERE idUtilisateur = :idUtilisateur";

        // Préparer et exécuter la requête
        $statement = $pdo->prepare($query);
        $statement->execute(array(':idUtilisateur' => $_SESSION['idUtilisateur']));

        
        $preferences = $statement->fetch(PDO::FETCH_ASSOC);

        
        return $preferences ? $preferences : NULL;
    }
    return NULL; // Retourner NULL si l'utilisateur n'est pas connecté
}
?>