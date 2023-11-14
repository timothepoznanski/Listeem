<?php

// // Debug
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

session_start();
require('./config.php');

if(isset($_POST["sign_up"])){

    // Récupérez le nom de la liste
    $list_name = $_POST['list_name'];

    // Récupérez l'emoji
    $list_emoji = $_POST['clicked_emoji'];

    // Supprimer les espaces au début et à la fin du nom de la liste
    $list_name = trim($list_name);

    // Vérifier si le nom de la liste est vide après avoir supprimé les espaces (par exemple si qqn ne met que des espaces)
    if (empty($list_name)) {
        // Le nom de la liste est vide, afficher un message d'erreur avec JavaScript
        // echo "<script>alert('Please enter a list name!'); window.location.href = document.referrer;</script>";
        header("location:create_list.php?msg=$var36");     
        exit; // Arrêter l'exécution du code restant
    }
    
    // Vérifier si la liste existe déjà (dans les listes du user connecté)
    $check_query = "SELECT * FROM lists WHERE list_name = ?";

    $stmt = mysqli_prepare($connect, $check_query);
    mysqli_stmt_bind_param($stmt, "s", $list_name);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);
    if(mysqli_num_rows($check_result) > 0){
        // La liste existe déjà, afficher un message d'erreur avec JavaScript
        // echo "<script>alert('The list already exists!'); window.location.href = document.referrer;</script>";   
        header("location:create_list.php?msg=$var37");
        exit();     
    }
    else{
        // Insérer la liste dans la base de données
        $date = date('Ymdhis');
        $date_access = date('Ymd');
        $query = "INSERT INTO lists VALUES(NULL, ?, ?, ?, ?, 0)";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $list_emoji, $list_name, $date, $date_access);
        $result = mysqli_stmt_execute($stmt);

        if($result){
            // Liste ajoutée avec succès
            header("Location: dashboard.php?msg=List created&list_name=" . urlencode($list_name) . "&list_emoji=" . urlencode($list_emoji));             
        }else{
            // Erreur lors de l'insertion
            header("location:create_list.php?msg=Something went wrong. Please try again!");  
        }
    }    
}
?>
