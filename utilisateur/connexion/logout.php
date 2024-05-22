<?php
// Démarrer la session
session_start();

// Détruire toutes les données de session
session_destroy();

// Rediriger vers la page de connexion
header("Location: login.html");
exit(); // Arrêter l'exécution du script après la redirection
?>
