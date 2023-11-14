<?php

session_start();
require('./config.php');

if(!isset($_SESSION['l_id']) || !isset($_SESSION["l_name"])) {
    header("location:dashboard.php");
    exit;
}

$list_id = $_SESSION['l_id'];

if(isset($_POST["item"])) {
    $item = htmlspecialchars($_POST["item"]);
    $item_escaped = mysqli_real_escape_string($connect, $item);
    $encrypted_item = openssl_encrypt($item_escaped, "AES-256-ECB", $key, OPENSSL_RAW_DATA);
    $encrypted_item_base64 = base64_encode($encrypted_item);

    // Récupérer la valeur minimale de item_order pour les items non importants.
    $query_order_min_non_important = "SELECT MIN(item_order) as min_order FROM listsitems WHERE list_id = '$list_id' AND important = 0";
    $result_order_min_non_important = mysqli_query($connect, $query_order_min_non_important);
    $row_order_min_non_important = mysqli_fetch_assoc($result_order_min_non_important);
    
    $new_order = isset($row_order_min_non_important['min_order']) ? $row_order_min_non_important['min_order'] : 1;
    
    // Incrémenter l'item_order de tous les items non importants par 1.
    $query_increment = "UPDATE listsitems SET item_order = item_order + 1 WHERE list_id = '$list_id' AND important = 0";
    mysqli_query($connect, $query_increment);

    // Ajouter le nouvel item avec l'item_order récupéré.
    $query = "INSERT INTO listsitems (list_id, item, checked, important, selected_date, item_order) VALUES('$list_id', '$encrypted_item_base64', 0, 0, NULL, '$new_order')";
    $result = mysqli_query($connect, $query);
   
    if($result) {
        header("location:dashboard.php");
    } else {
        echo "Error !";
        echo "<br/>";
        echo "<a href='dashboard.php'>Back</a>";
    }
}

?>
