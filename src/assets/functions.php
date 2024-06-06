<?php
// Inclure le fichier de configuration de la base de données
require_once 'env.php';

// Fonction pour récupérer les préférences de personnalisation de l'utilisateur connecté
function getUserPreferences() {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['idUtilisateur'])) {
        global $pdo; // Accès à l'objet PDO défini dans env.php

        // Préparer la requête SQL pour récupérer les préférences de personnalisation
        $query = "SELECT * FROM weirdle_personnalisation WHERE idUtilisateur = :idUtilisateur";

        // Préparer et exécuter la requête
        $statement = $pdo->prepare($query);
        $statement->execute(array(':idUtilisateur' => $_SESSION['idUtilisateur']));

        // Récupérer les résultats
        $preferences = $statement->fetch(PDO::FETCH_ASSOC);

        // Retourner les préférences si elles existent, sinon retourner NULL
        return $preferences ? $preferences : NULL;
    }
    return NULL; // Retourner NULL si l'utilisateur n'est pas connecté
}
?>