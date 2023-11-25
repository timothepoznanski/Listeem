<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

// $list_id=$_GET["list_id"];
$list_id = $_SESSION['l_id'];

$query = "SELECT hidden from lists WHERE list_id='$list_id'";
$result = mysqli_query($connect,$query);
if($result){
    $row = mysqli_fetch_assoc($result);
    $hidden = $row["hidden"];
    // Inverser la valeur de la colonne "hidden"
    $hidden = ($hidden == 1) ? 0 : 1;
}else{
    echo "A problem has occurred...";
    exit();
}

$query = "UPDATE lists SET hidden = '$hidden' WHERE list_id=$list_id";
$result = mysqli_query($connect,$query);
    if($result){
        //echo "The list has be hidden.<a href='dashboard.php'> Back</a>";
        header("location:dashboard.php");
    }else{
        echo "The list has not be hidden.<a href='dashboard.php'> Back</a>";
    }

?>