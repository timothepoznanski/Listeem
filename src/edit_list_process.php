<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

// Récupération des valeurs postées
$list_emoji = isset($_POST['clicked_emoji']) ? $_POST['clicked_emoji'] : '';
$list_name = isset($_POST['list_name']) ? $_POST['list_name'] : '';
$list_id = $_POST["list_id"];
$list_name = trim($list_name);
$list_old_name = $_POST["list_old_name"];

// Vérifier si la liste existe déjà (avec le même icone)
$check_query = "SELECT * FROM lists WHERE list_name = ? AND list_emoji = ?";
$stmt = mysqli_prepare($connect, $check_query);
mysqli_stmt_bind_param($stmt, 'ss', $list_name, $list_emoji); 
mysqli_stmt_execute($stmt);
$check_result = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($check_result) > 0) {
    // La liste existe déjà, afficher un message d'erreur avec JavaScript
    // echo "<script>alert('This list name already exists'); history.back();</script>";
    header("location:edit_list.php?msg=$var37"); 
    exit();
}

$query = "UPDATE lists SET list_name = ?, list_emoji = ? WHERE list_id = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 'sss', $list_name, $list_emoji, $list_id);
mysqli_stmt_execute($stmt);

if(mysqli_stmt_affected_rows($stmt) > 0) {
    header("location:dashboard.php?list_new_name=".$list_name."&list_new_emoji=".$list_emoji."");
} else {
    echo "A problem has occurred...";
}

?>
