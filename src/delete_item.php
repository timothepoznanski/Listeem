<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

$list_id = $_SESSION['l_id'];

if(isset($_GET["item_id"])){
    $item_id = $_GET["item_id"];
}

$query = "DELETE FROM listsitems WHERE item_id=$item_id";
$result = mysqli_query($connect,$query);
    if($result){
        header("location:dashboard.php");
    }else{
        echo "The item has not be deleted.<a href='dashboard.php'> Back</a>";
    }
?>