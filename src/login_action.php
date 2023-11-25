<?php
@ob_start(); // Démarre la temporisation de sortie

session_start();

// Vérification si le champ 'pass' est bien reçu via POST et qu'il n'est pas vide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['pass'])) {
    // Nettoyage et validation du mot de passe
    $cleaned_password = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);

    // Stockage du mot de passe dans la session
    $_SESSION['password'] = $cleaned_password;

    // Redirection vers une page sécurisée par exemple
    header('Location: ./check_password.php');
    exit();
} else {
    // Redirection vers une page d'erreur ou de retour si aucune donnée valide n'est reçue
    header('Location: ./login.php');
    exit();
}
?>
