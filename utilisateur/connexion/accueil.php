<?php
session_start();

// Vérification de la session utilisateur
if (isset($_SESSION['login_utilisateur'])) {
    // Redirection vers une autre page après 3 secondes
    header("refresh:3;url=../../chat/index.php");

    // Affichage du message de bienvenue
    echo "<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Bienvenue</title>
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
                color: #333;
            }
            a {
                color: #4CAF50;
                text-decoration: none;
                margin-top: 20px;
                display: inline-block;
                border: 2px solid #4CAF50;
                padding: 10px 20px;
                border-radius: 5px;
                transition: all 0.3s ease;
            }
            a:hover {
                background-color: #4CAF50;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1>Bienvenue, {$_SESSION['prenom']} {$_SESSION['nom']} !</h1>
            <p>Vous serez redirigé(e) vers une autre page dans quelques instants...</p>
            <a href='logout.php'>Déconnexion</a>
        </div>
    </body>
    </html>";
    exit(); // Arrêter l'exécution du script après la redirection
} else {
    // Si l'utilisateur n'est pas connecté, affiche un message d'erreur
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
            <h1>L'accès à cette page est réservé aux utilisateurs authentifiés</h1>
            <p>Redirection vers la page de connexion...</p>
        </div>
    </body>
    </html>";
    // Redirection vers la page de connexion après 3 secondes
    header("refresh:3;url=login.html");
    exit();
}
?>
