<?php
session_start();
require_once '../../persistance/dialogueBD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login_utilisateur'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $db = new DialogueBD();

    // Vérification si l'utilisateur existe dans la base de données
    $utilisateur_existe = $db->getCountUtilisateur($login);

    if ($utilisateur_existe > 0) {
        // L'utilisateur existe, on vérifie les informations de connexion
        $utilisateur = $db->getUtilisateur($login);
        $mot_de_passe_bdd = $utilisateur['PassUtil'];

        // Vérification du mot de passe
        if (password_verify($mot_de_passe, $mot_de_passe_bdd)) {
            // Authentification réussie
            $_SESSION['user_id'] = $utilisateur['id_utilisateur'];
            $_SESSION['login_utilisateur'] = $login;
            $_SESSION['nom'] = $utilisateur['NomUtil'];
            $_SESSION['prenom'] = $utilisateur['PrenomUtil'];

            header("Location: accueil.php"); // Rediriger vers la page d'accueil
            exit();
        } else {
            // Mot de passe incorrect
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
                    <h1>Mot de passe ou identifiant incorrect.</h1>
                    <p>Redirection vers la page de connexion...</p>
                </div>
            </body>
            </html>";
            // Redirection vers la page de connexion après 3 secondes
            header("refresh:2;url=login.html");
            exit();
        }
    } else {
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
                <h1>Vous n'avez pas été reconnu(e)</h1>
                <p>Redirection vers la page de connexion...</p>
            </div>
        </body>
        </html>";
        // Redirection vers la page de connexion après 3 secondes
        header("refresh:2;url=login.html");
        exit();
    }
} else {
    echo "Veuillez fournir un login et un mot de passe.";
}
?>
