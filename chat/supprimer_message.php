<?php
session_start();

require_once "../persistance/connexion.php"; // Assurez-vous que le chemin vers le fichier connexion.php est correct

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_message'])) {

    if (isset($_POST['id_message'])) {
        // Récupère l'ID du message à supprimer
        $id_message = $_POST['id_message'];

        // Connexion à la base de donnée
        $conn = Connexion::getConnexion();

        // Supprime le message de la base de donnée
        $sql_suppression_message = "DELETE  FROM message WHERE id_message = :id_message";
        $stmt_suppression_message = $conn->prepare($sql_suppression_message);
        $stmt_suppression_message->bindParam(':id_message', $id_message, PDO::PARAM_INT);

        if ($stmt_suppression_message->execute()) {
            header("refresh:0;url=index.php");
            exit(); 
        } else {
            echo "Erreur lors de la suppression du message.";
        }
    } else {
        echo "L'ID du message à supprimer n'est pas défini.";
    }
}

?>
