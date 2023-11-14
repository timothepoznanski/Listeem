<?php
require('./config.php');

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
