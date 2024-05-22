<?php
    session_start();
    require_once "../../../persistance/dialogueBD.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <style>
        body {
                font-family: Arial, sans-serif;
                background-color: #f7f7f7;
                margin: 0;
                padding: 0;
            }
    </style>
    <nav class="bg-dark d-flex align-items-center justify-content-center p-2 ">
        <a href="../../../chat/index.php"> <img src="../../../photo/icon_siochat.png" alt="icon" style="width: 80px; height : 80px;"></a>
    </nav>
    <h1 class="text-dark text-center mt-5">Modification du mot de passe du profil : <?php echo"{$_SESSION['login_utilisateur']}";?></h1>
    <div class=" container bg-secondary-subtle rounded col-4 p-4 mt-5">
    <h4 class="text-center">Entrez votre nouveau mot de passe</h4>

    <form action="traitementMDP.php" method="post" class="text-center mt-3 mb-3">
        
        <label for="newPassword">Nouveau Mot de Passe </label><br>
        <input type="password" id="newPassword" name="nouveauMDP"  required><br/><br>

        <label for="confirmNewPassword">Confirmer votre Mot de Passe </label><br>
        <input type="password" id="confirmNewPassword" name="confirmeMDP" required><br><br>

        <a href="../../../chat/index.php" class="btn btn-secondary">Retour a l'acceuil</a>
        <button type="submit" class="btn btn-primary">Modifier</button><br>
    </form>

    </div>
    

   
</body>
</html>