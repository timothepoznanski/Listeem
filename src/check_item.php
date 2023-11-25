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

// Check if "item_id" is set in the URL
if (isset($_GET["item_id"])) {
    $item_id = $_GET["item_id"];
} else {
    echo "Item ID not provided.";
    exit();
}

// Prepare and execute the SELECT query
$stmt = $connect->prepare("SELECT checked FROM listsitems WHERE item_id = ?");
$stmt->bind_param("i", $item_id);  // "i" means the parameter is an integer
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $checked = $row["checked"];
    
    // Inverse the "checked" value
    $checked = ($checked == 1) ? 0 : 1;

    // Prepare and execute the UPDATE query
    $stmt = $connect->prepare("UPDATE listsitems SET checked = ? WHERE item_id = ?");
    $stmt->bind_param("ii", $checked, $item_id);  // "ii" means both parameters are integers
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("location:dashboard.php");
    } else {
        echo "The item has not been checked. <a href='dashboard.php'>Back</a>";
    }
} else {
    echo "A problem has occurred...";
}

$stmt->close();
?>
