<?php

session_start();
require('./config.php');

$stmt = $connect->prepare("SELECT list_id, list_emoji, list_name FROM lists");

$stmt->execute();
$result = $stmt->get_result();

$output = "<html>
<head>
<title>All lists</title>
<meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title><?php echo $app_name_capital_min; ?></title>
    <style>
    body{
        padding: 20px;
        font-family: Segoe UI;
    }
    </style>
</head>
<body>";

while ($row = $result->fetch_assoc()) {
    $list_id = $row['list_id'];
    $list_emoji = $row['list_emoji'];
    $list_name = $row['list_name'];

    $stmt1 = $connect->prepare("SELECT item FROM listsitems WHERE list_id = ? AND checked = 0");
    $stmt1->bind_param("i", $list_id);

    $stmt1->execute();
    $result1 = $stmt1->get_result();

    if ($result1->num_rows > 0) {
        $output .= "<h3>$list_emoji $list_name</h3><ul>";

        while ($item_row = $result1->fetch_assoc()) {
            $encrypted_base64_item = $item_row["item"];
            $decrypted_base64_item = base64_decode($encrypted_base64_item);
            $decrypted = openssl_decrypt($decrypted_base64_item, "AES-256-ECB", $key, OPENSSL_RAW_DATA);
            $item_decrypted = stripslashes($decrypted);
            $output .= "<li>$item_decrypted</li>";
        }

        $output .= "</ul>";
    }

    $stmt1->close();
}

$stmt->close();

$output .= "</body></html>";

$filename = 'listeem_all.html';

header("Content-type: text/html; charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename");

echo $output;
?>
