<?php
//Classe qui permet la connexion à la base de donnée
class Connexion {
    //Déclaration de variable
    private $cnx = null;
    private $dbhost;
    private $dbbase;
    private $dbuser;
    private $dbpwd;

    //Méthode pour la connexion à la BDD
    public static function getConnexion(){
        //Iniatialisation variable avec les informations de connexion à la base de donnée
        $dbhost = 'localhost'; //L'hôte
        $dbbase = 'site_réseau'; //Nom de la base de donnée
        $dbuser = 'root'; //Identifiant utilisateur
        $dbpwd = ''; 

        try { 
            $cnx = new PDO("mysql:host=$dbhost;dbname=$dbbase", $dbuser, $dbpwd);
            $cnx->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $cnx->exec('SET CHARACTER SET utf8');
      } catch  (PDOException $e) { //Bloc qui intercepte et gère les erreurs
            $erreur = $e->getMessage();
        }
        return $cnx = new PDO("mysql:host=$dbhost;dbname=$dbbase", $dbuser, $dbpwd);
    }

    public static  function deConnexion(){

        try {
            $cnx=null;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        
        }
    }
}
?>
