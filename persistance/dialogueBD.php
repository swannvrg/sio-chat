<?php

require_once 'connexion.php';

class DialogueBD {
    

    
    
    // Méthode pour insérer un message dans la base de données
    public static function insererMessage($id_utilisateur, $contenu) {
        try {
            $conn = Connexion::getConnexion(); 
            $sql = "INSERT INTO message (id_utilisateur, contenu) VALUES (:id_utilisateur, :contenu)";
            $sth = $conn->prepare($sql);
            $sth->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT); 
            $sth->bindParam(':contenu', $contenu, PDO::PARAM_STR);
            $sth->execute(); 
            // Retourner l'ID du nouveau message inséré
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
            // Gérer l'erreur selon votre besoin
        }
    }
    public static function chargerMessages() {
        try {
            $conn = Connexion::getConnexion(); 
            $sql = "SELECT * FROM message ORDER BY id_message DESC"; // Récupérer les messages par ordre décroissant
            $sth = $conn->prepare($sql);
            $sth->execute(); 
            $messages = $sth->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les messages
            
            if ($messages === false || empty($messages)) {
                echo"<h3>Aucun message n'a été envoyé pour l'instant.</h3>";
                return array(); // ou return null; selon votre besoin
            }
            
            return $messages;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
            // Gérer l'erreur selon votre besoin
        }
    }
    
    public static function getPseudoUtilisateur($id_utilisateur) {
        try {
            $conn = Connexion::getConnexion(); 
            $sql = "SELECT LoginUtil FROM utilisateurs WHERE id_utilisateur = :id_utilisateur"; 
            $sth = $conn->prepare($sql);
            $sth->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT); 
            $sth->execute(); 
            $row = $sth->fetch(PDO::FETCH_ASSOC); 
            return $row['LoginUtil'];
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
            // Gérer l'erreur selon votre besoin
        }
    }
    
    

    public static function getIdUtilisateur($login_utilisateur) {
        try {
            $conn = Connexion::getConnexion(); 
            $sql = "SELECT id_utilisateur FROM utilisateurs WHERE LoginUtil = :login_utilisateur"; 
            $sth = $conn->prepare($sql);
            $sth->bindParam(':login_utilisateur', $login_utilisateur, PDO::PARAM_STR); 
            $sth->execute(); 
            $row = $sth->fetch(PDO::FETCH_ASSOC); 
            return $row['id_utilisateur'];
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
            // Gérer l'erreur selon votre besoin
        }
    }    

    public function getCountUtilisateur($login) {
        try {
            $conn = Connexion::getConnexion(); 
            $sql = "SELECT COUNT(*) FROM utilisateurs WHERE LoginUtil = :login_utilisateur"; 
            $sth = $conn->prepare($sql);
            $sth->bindParam(':login_utilisateur', $login, PDO::PARAM_STR); 
            $sth->execute();
            $nb = $sth->fetchColumn(); 
            return $nb;
        } catch (PDOException $e) {
            $erreur = $e->getMessage(); 
            
        }
    }
    

    public function getUtilisateur($login) {
        try {
            $conn = Connexion::getConnexion(); 
            $sql = "SELECT * FROM utilisateurs WHERE LoginUtil = :login_utilisateur"; 
            $sth = $conn->prepare($sql);
            $sth->bindParam(':login_utilisateur', $login, PDO::PARAM_STR); 
            $sth->execute(); 
            $utilisateur = $sth->fetch(PDO::FETCH_ASSOC); 
            return $utilisateur;
        } catch (PDOException $e) {
            $erreur = $e->getMessage();
        }
    }
    
}

?>
