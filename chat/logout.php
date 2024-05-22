<?php
// Démarrer la session
session_start();
 
// Détruire toutes les données de session
session_destroy();
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
        <h1>Vous venez de vous deconnecter !</h1>
        <p>Redirection vers la page de connexion...</p>
    </div>
</body>
</html>";
// Rediriger vers la page de connexion
header("refresh:2;url=../utilisateur/connexion/login.html");
exit(); // Arrêter l'exécution du script après la redirection
?>