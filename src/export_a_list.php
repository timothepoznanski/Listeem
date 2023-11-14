<?php

session_start();
require('./config.php');
$list_id = $_SESSION['l_id'];

// pas besoin de checker le owner de la liste car la requête recherche les listes du user connecté

$query = "SELECT list_name FROM lists WHERE list_id = '$list_id'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($result);
$list_name = $row['list_name'];

function replaceSpacesAndAccents($str) {
    // Remplacer les espaces par des underscores
    $filename_without_spaces = str_replace(' ', '_', $str);

    // Tableau des caractères accentués et leurs équivalents sans accents
    $accents = array(
        'à' => 'a', 'â' => 'a', 'ä' => 'a', 'á' => 'a', 'ã' => 'a', 'å' => 'a',
        'î' => 'i', 'ï' => 'i', 'ì' => 'i', 'í' => 'i',
        'ô' => 'o', 'ö' => 'o', 'ò' => 'o', 'ó' => 'o', 'õ' => 'o', 'ø' => 'o',
        'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'é' => 'e',
        'ç' => 'c', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ú' => 'u',
        'ÿ' => 'y', 'ñ' => 'n',
        'À' => 'A', 'Â' => 'A', 'Ä' => 'A', 'Á' => 'A', 'Ã' => 'A', 'Å' => 'A',
        'Î' => 'I', 'Ï' => 'I', 'Ì' => 'I', 'Í' => 'I',
        'Ô' => 'O', 'Ö' => 'O', 'Ò' => 'O', 'Ó' => 'O', 'Õ' => 'O', 'Ø' => 'O',
        'È' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'É' => 'E',
        'Ç' => 'C', 'Ù' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ú' => 'U',
        'Ÿ' => 'Y', 'Ñ' => 'N',
    );

    // Remplacer les caractères accentués
    $filename = strtr($filename_without_spaces, $accents);

    return $filename;
}

// Initialize the variable to store the HTML content
$output = "<html>
<head>
<title>My list exported</title>
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

    $output .= "<h3>$list_name</h3><ul>";

    $query = "SELECT item FROM listsitems WHERE list_id=$list_id AND checked = 0";
    $result1 = mysqli_query($connect, $query);

    while ($item_row = mysqli_fetch_assoc($result1)) {
        $encrypted_base64_item = $item_row["item"];
        $decrypted_base64_item = base64_decode($encrypted_base64_item);
        $decrypted = openssl_decrypt($decrypted_base64_item, "AES-256-ECB", $key, OPENSSL_RAW_DATA);
        $item_decrypted = stripslashes($decrypted);
        $output .= "<li>$item_decrypted</li>";
    }

    $output .= "</ul>";


$output .= "</body></html>";

// Nom du fichier à télécharger
$filename_sans_extension = replaceSpacesAndAccents($list_name );
$filename = $filename_sans_extension . ".html";

// En-têtes HTTP pour indiquer que c'est un fichier HTML à télécharger
header("Content-type: text/html; charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename"); // Si je veux juste afficher le contenu et pas le télécharger, commenter cette ligne

// Output the generated HTML content to trigger the download
echo $output;
?>
