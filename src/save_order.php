<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

if(isset($_POST['item'])) {
    $orderArray = $_POST['item'];
    foreach($orderArray as $order => $item_id) {
        $query = "UPDATE listsitems SET item_order = '$order' WHERE item_id = '$item_id'";
        $result = mysqli_query($connect, $query);
        if(!$result) {
            echo "Error updating order: " . mysqli_error($connect);
        }
    }
    echo "Order updated successfully!";
}
?>
