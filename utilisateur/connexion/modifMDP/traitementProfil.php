<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../../../persistance/connexion.php';

$connexion = Connexion::getConnexion();
$modificationReussie = false;
$userId = $_SESSION['user_id']; // Assurez-vous que l'ID de l'utilisateur est stocké dans la session

// Vérification des variables de session et POST
if (!isset($userId)) {
    die('User ID not found in session.');
}

if (isset($_POST['nom']) && !empty($_POST['nom'])) { 
    $nomModif = $_POST['nom'];
    $sqlModifNom = "UPDATE utilisateurs SET NomUtil=:nom WHERE id_utilisateur=:id";
    $sql = $connexion->prepare($sqlModifNom);
    $sql->bindParam(':nom', $nomModif);
    $sql->bindParam(':id', $userId);
    if ($sql->execute()) {
        $modificationReussie = true;
        $_SESSION['nom'] = $nomModif;
    }
}

if (isset($_POST['prenom']) && !empty($_POST['prenom'])) { 
    $prenomModif = $_POST['prenom'];
    $sqlModifPrenom = "UPDATE utilisateurs SET PrenomUtil=:prenom WHERE id_utilisateur=:id";
    $sql = $connexion->prepare($sqlModifPrenom);
    $sql->bindParam(':prenom', $prenomModif);
    $sql->bindParam(':id', $userId);
    if ($sql->execute()) {
        $modificationReussie = true;
        $_SESSION['prenom'] = $prenomModif;
    }
}

if (isset($_POST['login']) && !empty($_POST['login'])) { 
    $loginModif = $_POST['login'];
    $sqlModifLogin = "UPDATE utilisateurs SET LoginUtil=:login WHERE id_utilisateur=:id";
    $sql = $connexion->prepare($sqlModifLogin);
    $sql->bindParam(':login', $loginModif);
    $sql->bindParam(':id', $userId);
    if ($sql->execute()) {
        $modificationReussie = true;
        $_SESSION['login_utilisateur'] = $loginModif;
    }
}

// Maintenant, générer le HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <nav class="bg-dark d-flex align-items-center justify-content-center p-2">
        <a href="../../../chat/index.php">
            <img src="../../../photo/icon_siochat.png" alt="icon" style="width: 80px; height : 80px;">
        </a>
    </nav>
    <h1 class="text-dark text-center mt-5">Modification du profil : <?php echo $_SESSION['login_utilisateur'] ?></h1><br/>
    <div class="container bg-secondary-subtle rounded col-4 p-4 mt-3">
        <?php if ($modificationReussie) : ?>
            <h4 class="text-center">Modification réalisée avec succès</h4>
            <p class="text-center">Vous allez être dirigé vers la page d'accueil dans quelques instants, sinon cliquez <a href='../../../chat/index.php'>ici</a></p>
        <?php else : ?>
            <p class="text-center">Échec de la modification.</p>
        <?php endif; ?>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = '../../../chat/index.php';
        }, 3000);
    </script>
</body>
</html>
