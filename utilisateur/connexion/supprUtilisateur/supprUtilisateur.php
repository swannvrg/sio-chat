<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once "../../../persistance/dialogueBD.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['login_utilisateur'])) {
    echo "Utilisateur non connecté.";
    exit();
}

// Connexion à la base de données
$conn = Connexion::getConnexion();

// Vérifier si la connexion est établie
if (!$conn) {
    echo "Erreur de connexion à la base de données.";
    exit();
}

// Traitement du formulaire de suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login_utilisateur'];
    $motDePasse = $_POST['mot_de_passe'];

    // Récupérer l'utilisateur à supprimer
    $sql = "SELECT id_utilisateur, PassUtil FROM utilisateurs WHERE LoginUtil = :login";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $utilisateur = $stmt->fetch();

    // Vérifier les identifiants et mot de passe
    if ($utilisateur && password_verify($motDePasse, $utilisateur['PassUtil'])) {
        $id_utilisateur = $utilisateur['id_utilisateur'];

        try {
            $conn->beginTransaction();

            // Supprimer les messages associés à l'utilisateur
            $sqlDeleteMessages = "DELETE FROM message WHERE id_utilisateur = :id_utilisateur";
            $stmtDeleteMessages = $conn->prepare($sqlDeleteMessages);
            $stmtDeleteMessages->bindParam(':id_utilisateur', $id_utilisateur);
            $stmtDeleteMessages->execute();

            // Supprimer l'utilisateur
            $sqlDeleteUser = "DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur";
            $stmtDeleteUser = $conn->prepare($sqlDeleteUser);
            $stmtDeleteUser->bindParam(':id_utilisateur', $id_utilisateur);
            $stmtDeleteUser->execute();

            $conn->commit();

            // Redirection vers la page de confirmation après suppression
            header("Location: traitementSuppr.php");
            exit();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    } else {
        echo "Identifiant ou mot de passe incorrect.";
    }
}

// Début du contenu HTML
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        margin: 0;
        padding: 0;
    }
</style>
<nav class="bg-dark d-flex align-items-center justify-content-center p-2">
    <a href="../../../chat/index.php">
        <img src="../../../photo/icon_siochat.png" alt="icon" style="width: 80px; height: 80px;">
    </a>
</nav>
<body>
    <h1 class="text-dark text-center mt-5">Suppression du profil : <?php echo htmlspecialchars($_SESSION['login_utilisateur']); ?></h1>
    <div class="container bg-secondary-subtle rounded col-4 p-4 mt-5">
        <h4 class="text-center">Veuillez entrer vos identifiants pour confirmer la suppression</h4>
        <form action="" method="post" class="text-center mt-3 mb-3">
            <label for="login_utilisateur">Identifiant</label><br>
            <input type="text" name="login_utilisateur" id="login_utilisateur" required/><br><br>
            <label for="mot_de_passe">Mot de passe</label><br>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required/><br><br>
            <a href="../../../chat/index.php" class="btn btn-secondary">Retour à l'accueil</a>
            <button type="submit" class="btn btn-danger">Confirmer</button>
        </form>
    </div>
</body>
</html>
