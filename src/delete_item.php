<?php

session_start();
require('./config.php');
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