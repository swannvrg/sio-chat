<?php
session_start();

// Vérifier si la session login_utilisateur est définie
if (!isset($_SESSION['login_utilisateur'])) {
    die("Erreur: Session login_utilisateur non définie.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="bg-dark d-flex align-items-center justify-content-center p-2">
        <a href="../../../chat/index.php">
            <img src="../../../photo/icon_siochat.png" alt="icon" style="width: 80px; height: 80px;">
        </a>
    </nav>

    <div class="container mt-5">
        <h1 class="text-dark text-center">Suppression du profil : <?php echo htmlspecialchars($_SESSION['login_utilisateur']); ?></h1>
        <div class="container bg-secondary-subtle rounded col-4 p-4 mt-5">
            <h4 class="text-center">La suppression a été réalisée avec succès</h4>
            <p class="text-center">Vous allez être redirigé vers la page d'accueil dans quelques instants, sinon cliquez <a id="redirect-link" href="../../../index.php">ici</a></p>
        </div>
    </div>

    <script>
        console.log("Début de la redirection JavaScript");
        setTimeout(function() {
            console.log("Redirection en cours");
            window.location.href = "../../../index.php";
        }, 2000); // 2 secondes
    </script>

</body>
</html>
