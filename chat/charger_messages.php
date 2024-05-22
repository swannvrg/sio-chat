<?php
session_start(); // Démarrer la session

require_once "../persistance/dialogueBD.php";

// Récupérer tous les messages depuis la base de données
$messages = DialogueBD::chargerMessages();

// Inverser l'ordre des messages
$messages = array_reverse($messages);

// Récupérer l'ID de l'utilisateur actuel
$id_utilisateur_actuel = isset($_SESSION['login_utilisateur']) ? DialogueBD::getIdUtilisateur($_SESSION['login_utilisateur']) : null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
.message {
    margin-bottom: 10px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    max-width: 80%;
    position: relative;
}

.message.left {
    margin-right: auto;
    text-align: left;
}

.message.right {
    margin-left: auto;
    text-align: right;
}

.bouton-supprimer {
    background-color: #dc3545;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    position: absolute;
    top: 0;
    left: 0;
    display: none; /* Caché par défaut */
}

.message:hover .bouton-supprimer {
    display: block; /* Affiché lors du survol du message */
}
</style>
</head>
<script>
    // Ajoute la classe 'affiche' pour afficher le bouton de suppression
    function afficherBoutonSupprimer(message) {
        var boutonSupprimer = message.querySelector('.bouton-supprimer');
        boutonSupprimer.classList.add('affiche');
    }

    // Retire la classe 'affiche' pour masquer le bouton de suppression
    function masquerBoutonSupprimer(message) {
        var boutonSupprimer = message.querySelector('.bouton-supprimer');
        boutonSupprimer.classList.remove('affiche');
    }
</script>


<body>

<?php
foreach ($messages as $message) {
    // Récupère le pseudo de l'utilisateur à partir de son ID
// Récupère le pseudo de l'utilisateur à partir de son ID
$pseudo = DialogueBD::getPseudoUtilisateur($message['id_utilisateur']);

// Ajoute une icône à côté du pseudo



    // Vérifier si l'utilisateur actuel est l'auteur du message
    $est_utilisateur_actuel = ($id_utilisateur_actuel == $message['id_utilisateur']);

    // Défini la classe CSS pour l'alignement du message
    $alignement = $est_utilisateur_actuel ? 'right' : 'left';

    // Affiche le message avec le pseudo et l'alignement approprié 
    echo "<div class='message $alignement' onmouseover='afficherBoutonSupprimer(this)' onmouseout='masquerBoutonSupprimer(this)'>";
    
    // Ajouter le bouton de suppression avant le pseudo si l'utilisateur actuel est l'auteur du message
    if ($est_utilisateur_actuel) {
        echo "<form action='supprimer_message.php' method='POST' style='display: inline;'>";
        echo "<input type='hidden' name='id_message' value='{$message['id_message']}'>";
        echo "<button class='bouton-supprimer' type='submit' name='supprimer_message'>Supprimer</button>";
        echo "</form>";
    }

    echo "<strong><i class='fas fa-user'></i></strong>    <strong>$pseudo :</strong> {$message['contenu']}</div>";
}
?>

</body>
</html>
