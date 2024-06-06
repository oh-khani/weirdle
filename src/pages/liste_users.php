<?php
    require_once '../assets/header.php';
    if(isset($_POST['notConnected'])) header("Location: connexion.php");
?>

<?php
$requete = "SELECT idUtilisateur, pseudo FROM weirdle_utilisateur";
$stmt = dbQuery($requete);
$result = $stmt->fetchAll();
$betterResult = array_column($result, "pseudo", "idUtilisateur");
?>

<div class="table">
    <table>
        <thead>
            <tr>
                <th>Pseudo</th>
                <th>Gérer utilisateur</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($result as $user){
                    if (isset($_SESSION["user"]) && $user["pseudo"] == $_SESSION["user"]["pseudo"]) continue;
                    echo "<tr>";
                        echo "<td>$user[pseudo]</td>";
                        echo "<td>";
                        if (isset($_SESSION["user"]) && $user["pseudo"]){
                            echo "<form action='liste_users.php' method='POST'>";
                            echo "<input type='hidden' name='receiver_id' value='$user[idUtilisateur]'>";
                            echo "<button type='submit'>Envoyer une demande d'ami</button>";
                            echo "</form>";
                        }else{
                            echo "<form action='liste_users.php' method='POST'>";
                            echo "<input type='hidden' name='notConnected' value='true'>";
                            echo "<button type='submit'>Se connecter</button>";
                            echo "</form>";
                        }
                        echo "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<?php
if (isset($_SESSION['user'])) {
    echo "<h2>Utilisateurs</h2>";

    $sender_id = $_SESSION['user']['idUtilisateur'];
    if (isset($_POST['receiver_id'])){
        $receiver_id = $_POST['receiver_id'];

        // Vérifier si une demande existe déjà
        $query = "SELECT * FROM weirdle_amis_demandes WHERE sender_id = $sender_id AND receiver_id = $receiver_id";
        $stmt = dbQuery($query);
        $existing_request = $stmt->fetchAll();

        if ($existing_request) {
            echo "Vous avez déjà envoyé une demande à cet utilisateur.";
        } else {
            // Insérer la demande d'ami
            $query = "INSERT INTO weirdle_amis_demandes (sender_id, receiver_id) VALUES ($sender_id, $receiver_id)";
            $stmt = dbQuery($query);
            if ($stmt) {
                echo "Demande d'ami envoyée avec succès.";
            } else {
                echo "Erreur lors de l'envoi de la demande.";
            }
        }
    }
} else {
    echo "<h2>Vous devez être connecté pour envoyer une demande d'ami.</h2>";
}
require_once '../assets/footer.php';
?>