<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../../../persistance/dialogueBD.php";

// Démarre la sortie tampon pour éviter les problèmes de headers already sent
ob_start();

// Vérifier si les données ont été envoyées via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['login_utilisateur'])) {
        $idUtilisateur = $_SESSION['login_utilisateur'];
    } else {
        echo "Utilisateur non connecté.";
        ob_end_flush(); // Fin de la sortie tampon et envoi de la sortie au navigateur
        exit();
    }

    $nouveauMotDePasse = $_POST['nouveauMDP'];
    $confirmationMotDePasse = $_POST['confirmeMDP'];

    // Vérifier si les deux mots de passe correspondent
    if ($nouveauMotDePasse !== $confirmationMotDePasse) {
        echo "Les mots de passe ne correspondent pas.";
        ob_end_flush(); // Fin de la sortie tampon et envoi de la sortie au navigateur
        exit();
    }

    try {
        // Connexion à la base de données
        $conn = Connexion::getConnexion(); // Assurez-vous de remplacer Connexion::getConnexion() par votre méthode de connexion à la base de données

        // Hasher le nouveau mot de passe
        $nouveauMotDePasseHash = password_hash($nouveauMotDePasse, PASSWORD_DEFAULT);

        // Préparation de la requête SQL pour mettre à jour le mot de passe
        $sql = "UPDATE utilisateurs SET PassUtil = :nouveauMotDePasse WHERE LoginUtil = :idUtilisateur";
        $stmt = $conn->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nouveauMotDePasse', $nouveauMotDePasseHash, PDO::PARAM_STR);
        $stmt->bindParam(':idUtilisateur', $idUtilisateur, PDO::PARAM_STR);

        // Exécution de la requête
        $stmt->execute();

        // Vérification si la mise à jour a réussi
        if ($stmt->rowCount() > 0) {
            // Le mot de passe a été modifié avec succès
            ?>
            
           
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Modification</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

            </head>
            <body> 
                <nav class="bg-dark d-flex align-items-center justify-content-center p-2">
                    <a href="../../../chat/index.php">
                        <img src="../../../photo/icon_siochat.png" alt="icon" style="width: 80px; height: 80px;">
                    </a>
                </nav>

                <div class="container mt-5">
                    <h1 class="text-dark text-center mt-5">Modification du mot de passe du profil : <?php echo"{$_SESSION['login_utilisateur']}";?></h1>
                     <div class="container bg-secondary-subtle rounded col-4 p-4 mt-5">
                        <h4 class="text-dark text-center">Le mot de passe a été modifié avec succès.</h4>
                        <p class="text-center">Vous allez être dirigé vers la page d'accueil dans quelques instants, sinon cliquez <a href='../login.html'>ici</a></p>
                    </div>
                </div>
                
            </body>
            </html>

            <?php

            // Redirection vers la page de connexion après 3 secondes
            
            header("refresh:3;url=../login.html");
            ob_end_flush(); // Fin de la sortie tampon et envoi de la sortie au navigateur
            exit();
        } else {
            echo "Échec de la modification du mot de passe.";
            ob_end_flush(); // Fin de la sortie tampon et envoi de la sortie au navigateur
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        ob_end_flush(); // Fin de la sortie tampon et envoi de la sortie au navigateur
    }
}
?>
