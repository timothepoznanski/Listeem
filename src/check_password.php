<?php
session_start();
require('./config.php');

$user_password = $_SESSION['password']; // Récupération du mot de passe entré par l'utilisateur

// Vérification si le mot de passe entré correspond au mot de passe stocké en base de données
if ($user_password === $app_password) {
    // Mot de passe correct : créer une session authentifiée
    $_SESSION['auth'] = true;
    // Redirection vers une page sécurisée ou page d'accueil, etc.
    header('Location: ./home.php');
    exit();
} else {
    // Mot de passe incorrect : rediriger vers une page d'erreur ou de connexion
    header('Location: ./login.php');
    exit();
}
?>
