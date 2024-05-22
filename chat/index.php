<?php
ob_start();

session_start();
 
require_once "../persistance/dialogueBD.php"; // Inclure la classe DialogueBD
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITE SIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <style>
        .body {
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


        .scroll{
            background-color: #fed9ff;
            width: 86vh;
            height: 50vh;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: center;
            
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/7823ce7968.js" crossorigin="anonymous"></script>
    <script>

        $(document).ready(function() {
            function chargerMessages() {
                $.ajax({
                    url: 'charger_messages.php', 
                    method: 'POST',
                    success: function(data) {
                        $('#messages').html(data); 
                    }
                });
            }
 
            // Charger les messages au chargement de la page et toutes les 5 secondes
            chargerMessages();
            setInterval(chargerMessages, 200); // Toutes les 5 secondes
        });
    </script>
</body>

</head>
 
<body>
    <?php
 
if (isset($_SESSION['login_utilisateur'])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Envoyer'])) {
        $pseudo = $_SESSION['login_utilisateur'];
        $message = $_POST['message'];
        $id_utilisateur = DialogueBD::getIdUtilisateur($_SESSION['login_utilisateur']);
        DialogueBD::insererMessage($id_utilisateur, $message);
 
        // Redirection vers la même page pour éviter la réémission des données POST
        header("Location: index.php");
        exit();
    }
    ?>
    
    <nav class="bg-dark">
        <div class=" d-flex align-items-center justify-content-between p-2">
            <div>
                <img src="../photo/icon_siochat.png" alt="icon" style="width: 80px; height : 80px;">
            </div>
            <div><h1>SIO Chat</h1></div>
            <div>
                
                <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#ProfilModal"><i class="fa-solid fa-user"></i></button>
                 <!-- Modal Profil -->
                <div class="modal fade" id="ProfilModal" tabindex="-1" aria-labelledby="ProfilModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-dark" id="ProfilModalLabel">Nom d'utilisateur : <?php echo "{$_SESSION['login_utilisateur']}" ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center ">
                        <ul class="list-group">
                            <li class="list-group-item"><a href="../utilisateur/connexion/modifMDP/modifProfil.php"><button type="button" class="btn btn-primary" data-bs-dismiss="modal">Modifier le profil</button></a></li>
                            <li class="list-group-item"><a href="../utilisateur/connexion/logout.php"><button class="btn btn-danger">Déconnexion</button></a></li>
                            <li class="list-group-item"><button type="button" class="btn btn-danger" data-bs-target="#Suppression" data-bs-toggle="modal">Supprimer le profil</button></li>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
                <!-- 2eme modal suppr -->
                <div class="modal fade" id="Suppression" aria-hidden="true" aria-labelledby="SuppressionLabel2" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 text-dark" id="SuppressionLabel2">Profil : <?php echo "{$_SESSION['login_utilisateur']}" ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Etes vous sur de vouloir supprimmer votre compte ?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-target="#ProfilModal" data-bs-toggle="modal">Annuler</button>
                        <a href="../utilisateur/connexion/supprUtilisateur/supprUtilisateur.php"><button class="btn btn-danger">Supprimer votre compte</button></a>
                    </div>
                    </div>
                
               
                
                    
                </div>
                </div>
            </div>
 
    </nav>
   
    <div class="container">
      
       
        <?php
        // Vérification de la session utilisateur
       
           
            // Vérifier si le formulaire est soumis
            if (isset($_POST['Envoyer'])) {
                // Récupérer le pseudo de l'utilisateur à partir de la session
                $pseudo = $_SESSION['login_utilisateur'];
 
                // Récupérer le message à partir du formulaire
                $message = $_POST['message'];
 
                // Récupérer l'ID de l'utilisateur à partir du pseudo
                $id_utilisateur = DialogueBD::getIdUtilisateur($_SESSION['login_utilisateur']);
 
                // Appeler la fonction pour insérer le message dans la base de données
                DialogueBD::insererMessage($id_utilisateur, $message);
 
                // Afficher un message de succès ou de confirmation
               
                echo "Le message a été envoyé avec succès !";
            }
            // Afficher le formulaire
           
           
           
       
        ?><div class="bg-secondary-subtle rounded p-5">
            <div class="bg-light p-4 overflow-auto"  style="height:400px, max-width: auto;">
             <section id="messages"></section>
            </div>
        </div>
       
        <div class="row">
        <div class="mt-4 col-9 row">
            <form action="" method="POST" class="d-flex align-items-center">
                <input type="text" name="message" class="offset-1 col-5 form-control">
               
                <input type="submit" name="Envoyer" value="Envoyer" class="offset-1 btn  btn-primary">
            </form>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
<?php
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
                    <h1>L'accès est réservé aux Utilisateurs =</h1>
                    <p>Redirection vers la page de connexion...</p>
                </div>
            </body>
            </html>";
            // Redirection vers la page de connexion après 3 secondes
            header("refresh:3;url=../utilisateur/connexion/login.html");
            exit();
        }
        
        ob_end_flush();
?>