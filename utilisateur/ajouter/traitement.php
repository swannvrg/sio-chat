<?php

ob_start();

session_start();
 
require_once '../../persistance/connexion.php';
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $login = $_POST['login_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];
 
    $connexion = Connexion::getConnexion();
 
    // Vérifier si le nom d'utilisateur existe déjà dans la base de données
    $sql_verification = "SELECT COUNT(*) FROM utilisateurs WHERE LoginUtil = :login_utilisateur";
    $stmt_verification = $connexion->prepare($sql_verification);
    $stmt_verification->bindParam(':login_utilisateur', $login);
    $stmt_verification->execute();
    $count = $stmt_verification->fetchColumn();
 
    if ($count > 0) {
        echo "<!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Accès refusé</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f7f7f7;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 800px;
                    margin: 50px auto;
                    text-align: center;
                }
                h1 {
                    color: #ff3333;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>Le nom d'utilisateur que vous avez saisi a déjà été utilisé</h1>
                <br>
                <p>Redirection vers la page d'inscription...</p>
            </div>
        </body>
        </html>";
        // Redirection vers la page de connexion après 3 secondes
        header("refresh:3;url=../connexion/login.html");
        exit();
    } else {
        // Hachage du mot de passe
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
 
        // Insertion des données dans la base de données avec le mot de passe haché
        $sql_insertion = "INSERT INTO utilisateurs (NomUtil, PrenomUtil, LoginUtil, PassUtil) VALUES (:nom, :prenom, :login_utilisateur, :mot_de_passe)";
       
        $stmt_insertion = $connexion->prepare($sql_insertion);
        $stmt_insertion->bindParam(':nom', $nom);
        $stmt_insertion->bindParam(':prenom', $prenom);
        $stmt_insertion->bindParam(':login_utilisateur', $login);
        $stmt_insertion->bindParam(':mot_de_passe', $mot_de_passe_hache);
 
        try {
            $connexion->beginTransaction();
 
            if ($stmt_insertion->execute()) {
                $connexion->commit();
                echo "<!DOCTYPE html>
                <html lang='fr'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Inscription réussie</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f7f7f7;
                            margin: 0;
                            padding: 0;
                        }
                        .container {
                            max-width: 800px;
                            margin: 50px auto;
                            text-align: center;
                        }
                        h1 {
                            color: #ff3333;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <h1>Inscription réussie</h1>
                        <p>Vous allez être redirigé vers la page de connexion...</p>
                    </div>
                </body>
                </html>";
                header("refresh:3;url=../connexion/login.html");
                exit();
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement dans la table 'utilisateurs'.";
                $connexion->rollback();
            }
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }
} else {
    // Si aucune donnée n'a été soumise via POST, affiche un message d'erreur
    echo "Veuillez fournir toutes les informations nécessaires.";
}
 
ob_end_flush();

?>
