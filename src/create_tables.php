<?php

require('./config.php');

// Create bdd table lists
$query_create_lists = "CREATE TABLE `lists` (
    `list_id` int NOT NULL AUTO_INCREMENT,
    `list_emoji` varchar(10) DEFAULT NULL,
    `list_name` varchar(50) NOT NULL,
    `list_date` varchar(50) DEFAULT NULL,
    `date_access` varchar(20) DEFAULT NULL,
    `hidden` int NOT NULL DEFAULT '0',
    PRIMARY KEY (`list_id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

if (mysqli_query($connect, $query_create_lists)) {
    //echo "New table lists created.";  // Uncomment for debug
} else {
    //echo mysqli_error($connect);  // Uncomment for debug
}

echo "<br>";

// Create bdd table listsitems
$query_create_listsitems = "CREATE TABLE `listsitems` (
    `item_id` int NOT NULL AUTO_INCREMENT,
    `list_id` int NOT NULL,
    `item` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `important` int DEFAULT NULL,
    `checked` int DEFAULT NULL,
    `selected_date` date DEFAULT NULL,
    `item_order` int DEFAULT NULL,
    PRIMARY KEY (`item_id`),
    KEY `list_id` (`list_id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;";

if (mysqli_query($connect, $query_create_listsitems)) {
    //echo "New table listsitems created.";  // Uncomment for debug
} else {
    //echo mysqli_error($connect);  // Uncomment for debug
}



