<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

$item_id = $_POST['item_id'];
$new_item = $_POST['new_item'];

// Récupérer la date sélectionnée
if(isset($_POST["selected_date"])){
    if($_POST["selected_date"] == ''){
        $selected_date = NULL;
    }
    else{
        $selected_date = $_POST['selected_date'];
    }
}
else{
    $selected_date = NULL;
}

// Récupérer l'id de la liste à laquelle appartient cet item
$query = "SELECT li.list_id 
          FROM listsitems li
          JOIN lists l ON li.list_id = l.list_id
          WHERE li.item_id = ?";

$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 's', $item_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $list_id = $row['list_id'];
} else {
    header("location:home.php?msg=We cannot find the list id of this item!");
    exit();
}

$item_escaped = mysqli_real_escape_string($connect, $new_item);

// Chiffrement en mode ECB sans vecteur d'initialisation
$encrypted_item = openssl_encrypt($item_escaped, "AES-256-ECB", $key, OPENSSL_RAW_DATA);

// Encodage en base64 pour stockage ou transmission
$encrypted_item_base64 = base64_encode($encrypted_item);

if (isset($_POST['important'])) {
    // La case est cochée
    $important = 1;

    // Récupérer la valeur minimale d'item_order parmi tous les éléments
    $query_order_min = "SELECT MIN(item_order) as min_order FROM listsitems WHERE list_id = '$list_id'";
    $result_order_min = mysqli_query($connect, $query_order_min);
    $row_order_min = mysqli_fetch_assoc($result_order_min);

    $new_order = isset($row_order_min['min_order']) ? $row_order_min['min_order'] : 1;

} else {
    // La case n'est pas cochée
    $important = 0;

    // Récupérer la valeur minimale d'item_order pour les éléments non importants
    $query_order_min_non_important = "SELECT MIN(item_order) as min_order FROM listsitems WHERE list_id = '$list_id' AND important = 0";
    $result_order_min_non_important = mysqli_query($connect, $query_order_min_non_important);
    $row_order_min_non_important = mysqli_fetch_assoc($result_order_min_non_important);

    $new_order = isset($row_order_min_non_important['min_order']) ? $row_order_min_non_important['min_order'] : 1;
}

// Mettre à jour la base de données avec la date
$stmt = $connect->prepare("UPDATE listsitems SET selected_date = ? WHERE item_id = ?");
$stmt->bind_param("ss", $selected_date, $item_id);

if ($stmt->execute()) {
    // La mise à jour a réussi
} else {
    // La mise à jour a échoué
    echo "Erreur : " . $stmt->error;
}

// Mettre à jour la base de données avec la valeur de la case cochée
$updateQuery = "UPDATE listsitems SET important = $important WHERE item_id = '$item_id'";
$updateResult = mysqli_query($connect, $updateQuery);
if (!$updateResult) {
    echo "La mise à jour a échoué : " . mysqli_error($connect);
}

// Mettre à jour la base de données avec le texte de l'élément et le nouvel item_order
$query = "UPDATE listsitems SET item = '$encrypted_item_base64', item_order = '$new_order' WHERE item_id = '$item_id'";
$result = mysqli_query($connect, $query);

if($result){
    header("location:dashboard.php");
}else{
    echo "Input too long (no more than 255 characters please)."; // pour le développeur, ça peut aussi être un souci avec la requête par exemple une nouvelle colonne créée mais on a pas modifié le INSERT
    echo "<br/>";
    echo "<a href='dashboard.php'> Back</a>";
}

?>
