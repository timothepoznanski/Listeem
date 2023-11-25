<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

// $list_id = $_SESSION['l_id'];
$list_id = $_GET['list_id'];

// We remove the list and all its items
$query = "DELETE from lists WHERE list_id='$list_id'";
$result = mysqli_query($connect,$query);
if($result){
    $query = "DELETE from listsitems WHERE list_id='$list_id'";
    $result = mysqli_query($connect,$query);
    header("location:my_lists.php");
}else{
    echo "Error. The list has not been deleted.";
}


?>