<?php
session_start();
require_once '../../../persistance/dialogueBD.php';
$connexion = Connexion::getConnexion(); 

$login = $_SESSION['login_utilisateur'];
$user = null;

if(isset($login)) {
    $sql = "SELECT * FROM utilisateurs WHERE LoginUtil = :login";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':login', $login);
    $stmt->execute();
    $user = $stmt->fetch();
}

$nom = isset($user['NomUtil']) ? $user['NomUtil'] : '';
$prenom = isset($user['PrenomUtil']) ? $user['PrenomUtil'] : '';
$loginUser = isset($user['LoginUtil']) ? $user['LoginUtil'] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification profil</title>
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
<body>
    <nav class="bg-dark d-flex align-items-center justify-content-center p-2 ">
           <a href="../../../chat/index.php"> <img src="../../../photo/icon_siochat.png" alt="icon" style="width: 80px; height : 80px;"></a>
    </nav>
    <h1 class="text-dark text-center mt-5">Modification du profil : <?php echo htmlspecialchars($loginUser); ?></h1><br/>
    <div class="container bg-secondary-subtle rounded col-4 p-4 mt-3 ">
        <h4 class="text-center">Remplacez ce que vous voulez modifier</h4>
        <form action="traitementProfil.php" method="post" >
            <div class="text-center mt-3 mb-3">
                <label for="name">Nom : <?php echo isset($_SESSION['nom']) ? $_SESSION['nom'] : ''; ?></label><br> 
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>"><br><br>
                <label for="prenom">Prenom : <?php echo isset($_SESSION['prenom']) ? $_SESSION['prenom'] : ''; ?></label><br> 
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>"><br><br>
                <label for="login">Nom d'utilisateur : <?php echo isset($_SESSION['login_utilisateur']) ? $_SESSION['login_utilisateur'] : ''; ?></label><br> 
                <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($loginUser); ?>"><br><br>
                
                <a href="../../../chat/index.php" class="btn btn-secondary">Retour à l'accueil</a>
                <button type="submit" class="btn btn-primary">Modifier</button><br>
               
                <a href="../modifMDP/modifMdp.php">Modifier le mot de passe</a>
            </div>    
        </form>
    </div>
</body>
</html>
