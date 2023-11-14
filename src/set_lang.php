<?php
session_start();

// Positionner un cookie pour la lang

if (isset($_POST['lang'])) {
    // $_SESSION['lang'] = $_POST['lang'];

    $lang = $_POST['lang'];

    // Créer le cookie qui expire dans 30 jours
    setcookie('lang', $lang, time() + (86400 * 30), "/"); // 86400 = 1 jour en secondes

}

?>



