<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

if(isset($_GET["list_name"])){ // Si on vient de la page create
    $l_name = trim($_GET["list_name"]);
    $l_emoji = trim($_GET["list_emoji"]);                  
}
    
if (isset($l_name) && !empty($l_name)) {
    // Prepare the SQL query
    $stmt = mysqli_prepare($connect, "SELECT * FROM lists WHERE list_name = ?");
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "s", $l_name);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get results
    $result = mysqli_stmt_get_result($stmt);
    $rowcount = mysqli_num_rows($result);

    if ($rowcount == true) {
        $_SESSION["l_name"] = $l_name; 
        // No need for a second query that's the same as the first one. 
        // We can just use the $result from above.
        $row2 = mysqli_fetch_array($result);
        $_SESSION["l_id"] = $row2["list_id"];
        $_SESSION["l_emoji"] = $row2["list_emoji"];        
        header("location:dashboard.php");
    } else {
        header("location:index.php");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

if ($_SESSION["l_id"]) {
    $name = $_SESSION["l_name"];
    $emoji = $_SESSION["l_emoji"];
    $id = $_SESSION["l_id"];
}

if ($_GET["list_new_name"] == true) {
    $name = $_GET["list_new_name"];
    $_SESSION["l_name"] = $name;
}

if ($_GET["list_new_emoji"] == true) {
    $emoji = $_GET["list_new_emoji"];
    $_SESSION["l_emoji"] = $emoji;
}

// Mettre à jour la date d'access à la liste
$currentDate = date("Ymd");
$updateQuery = "UPDATE lists SET date_access = '$currentDate' WHERE list_id = $id";
if (mysqli_query($connect, $updateQuery)) {
    echo "";
} else {
    echo "Error TPO1 : " . mysqli_error($connect);
}

// Vérifiez si un élément de la liste a une date
$query_has_date = "SELECT COUNT(*) as count FROM listsitems WHERE list_id = $id AND selected_date IS NOT NULL";
$result_has_date = mysqli_query($connect, $query_has_date);
$row_has_date = mysqli_fetch_assoc($result_has_date);
$has_date = $row_has_date['count'] > 0;

// Récupérer les noms des listes pas cachées
$query_lists = "SELECT list_emoji, list_name FROM lists WHERE hidden = 0";
$stmt = $connect->prepare($query_lists);
$stmt->execute();
$result = $stmt->get_result();


while ($row = $result->fetch_assoc()) {  
    $list_name = trim($row["list_name"]); 
    $list_emoji = $row["list_emoji"]; 
    $listData[] = $row;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $app_name_capital_min; ?></title>
    
    <!-- Step 1: Include full version of jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- Step 2: Include jQuery UI after jQuery / Besoin pour pouvoir déplacer les lignes sur pc -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Step 3: Bootstrap comes after jQuery and jQuery UI -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="dashboard_style.css">
    <!-- Besoin pour les cases à cocher -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="shortcut icon" href="favicon.png" type="image/x-icon"/>
</head>


<script>
    function confirmDelete(message) {
        return confirm(message);
    }

    // A chaque chargement de la page, on focus sur l'input mais sur téléphone ça ouvre le clavier à chaque fois c'est pénible
    // window.onload = function() {
    //     var inputField = document.getElementById('input-add');
    //     inputField.focus();
    // };

    $(function() {
        $(".table-dashboard tbody").sortable({
            update: function(event, ui) {
                var order = $(this).sortable("serialize");

                // Post the new order to a PHP file to save in the database
                $.post("save_order.php", order);
            }
        });
    });

    // Fonction pour vérifier la largeur de l'écran et basculer l'affichage de la sidebar
    function toggleSidebar() {
        var screenWidth = $(window).width(); // Obtenez la largeur de l'écran

        if (screenWidth <= 1150) { // Par exemple, basculez à une largeur de 768 pixels
            // Masquer la sidebar
            $(".sidebar").hide();
        } else {
            // Afficher la sidebar
            $(".sidebar").show();
        }
    }

    // Exécutez la fonction lors du chargement de la page
    $(document).ready(function() {
        toggleSidebar();

        // Exécutez la fonction lorsque la fenêtre est redimensionnée
        $(window).resize(function() {
            toggleSidebar();
        });
    });

</script>

<body class="my-custom-class">

    <br>
    
    <div class="row">

        <!-- Barre latérale gauche -->
        <div class="col-lg-1 sidebar">
            <ul class="list-group">
                <?php
                    if(isset($listData)){ // If there is list not hidden
                        // Trier le tableau par ordre alphabétique (sans tenir compte de la casse et en plaçant les chiffres en premier et dans l'ordre (pas 10 après 1 par exemple))                    
                        usort($listData, function($a, $b) {
                            $numA = intval($a['list_name']);
                            $numB = intval($b['list_name']);
                        
                            if ($numA !== 0 && $numB !== 0) {
                                // Si les deux sont des nombres, les comparer numériquement
                                return $numA - $numB;
                            } elseif ($numA !== 0) {
                                // Si seul le premier est un nombre, il va en premier
                                return -1;
                            } elseif ($numB !== 0) {
                                // Si seul le deuxième est un nombre, il va en premier
                                return 1;
                            } else {
                                // Si les deux ne sont pas des nombres, comparer alphabétiquement sans tenir compte de la casse
                                return strcasecmp($a['list_name'], $b['list_name']);
                            }
                        }); 
                        
                        // Boucle foreach pour parcourir les noms de liste
                        foreach ($listData as $row) {
                            $list_name = $row["list_name"];
                            $list_emoji = $row["list_emoji"];
                            $listNameUrlEncoded = urlencode($list_name);
                            $listNameDisplayed = $list_emoji . "&nbsp;&nbsp;&nbsp;" . $list_name; // Attention j'ai mis deux espaces entre l'emoji et le nom de la liste juste pour l'affichage
                            echo '<li class="list-group-item"><a href="dashboard.php?list_name=' . $listNameUrlEncoded . '" class="list-group-item-lien">' . $listNameDisplayed . '</a></li>';
                        }
                    }
                ?>
            </ul>
        </div>

        <div class="col-lg-10 header">
            <div class="nav">
                <div style="margin-top: 15px">
                    <a href="edit_list.php?list_id=<?php echo $id; ?>" class="btn btn-outline-info ellipsis" style="text-decoration: none; margin-right: 25px;">
                        <span class="text-colored"><?php echo $emoji . "&nbsp;&nbsp;" . $name; ?></span>
                    </a>
                    <a href="my_lists.php" title="<?php echo $var44 ?>" class="btn btn-outline-info">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                </div>
                
            </div>

        <div class="nav2">
            <form class="form-row align-items-center d-flex" method="post" action="add_item_process.php">
                <input type="hidden" name="list_id" value="<?php echo $id; ?>">

                <div class="col-12 position-relative">
                    <input id="input-add" type="text" name="item" class="form-control input-add" placeholder="<?php echo $var46 ?>" required maxlength="300">
                    <button type="submit" class="btn-submit-icon">
                        <i class="fas fa-plus icon-colored"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-12 data table-container">
            <table id="my_table" class="table table-dashboard">
                <tbody>
                    
                    <?php
                    // Par cette requête pour récupérer les éléments avec l'ordre inversé, en triant par "checked" d'abord, puis par "important"
                    $query = "SELECT * FROM listsitems WHERE list_id = $id ORDER BY checked ASC, important DESC, item_order ASC";

                    $result = mysqli_query($connect, $query);

                    while ($row = mysqli_fetch_array($result)) {                        

                        $selected_date = $row["selected_date"];

                        // Vérifier la date et calculer les jours restants
                        $days_text = "";
                        if(!empty($selected_date)) {
                            $today = new DateTime();
                            $today->setTime(0, 0);
                            $selectedDate = new DateTime($selected_date);
                            $selectedDate->setTime(0, 0);

                            $interval = $today->diff($selectedDate);
                            $days_remaining = null;
                            $is_date_passed_or_today = false;

                            if ($today < $selectedDate) {
                                $days_remaining = $interval->days;  // Nombre de jours restants
                            } elseif ($today >= $selectedDate) {
                                $is_date_passed_or_today = true; // Si la date est aujourd'hui ou est passée
                            }
                        }

                        $item_id = $row["item_id"];
                        $encrypted_base64 = $row["item"];
                        $encrypted = base64_decode($encrypted_base64);
                        $decrypted = openssl_decrypt($encrypted, "AES-256-ECB", $key, OPENSSL_RAW_DATA);
                        $item = stripslashes($decrypted);
                        $isChecked = $row['checked'];
                        $isImportant = $row['important'];
                    ?>  
                        <!-- Ajout d'une ligne entre les ligne que je fais disparaitre pour avoir un effet de séparation entre les lignes des listes pointer-events none pour ne pas pouvoir cliquer dessus -->
                        <!-- <tr style='pointer-events: none;'>
                            <td style='padding: 0; border: 0px; box-shadow: None;'><div style='min-height: 5px;'></div></td>
                        </tr> -->
                        <!-- Lignes avec les items -->
                        <tr id="item_<?php echo $item_id; ?>">
                            <?php if ($isChecked == 1): ?>
                                <td><a href="delete_item.php?item_id=<?php echo $item_id; ?>"><span class="input-group-text"><i class="fa fa-trash  icon-colored"></i></span></a></td>
                                <?php if ($isImportant == 1): ?>
                                    <td>
                                        <a href="check_item.php?item_id=<?php echo $item_id; ?>" class="full-cell-link-red">
                                            <del><span><?php echo $item; ?></span></del>
                                        </a>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <a href="check_item.php?item_id=<?php echo $item_id; ?>" class="full-cell-link">
                                            <del><?php echo $item; ?></del>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <?php else: ?>
                                <td>
                                    <a href="check_item.php?item_id=<?php echo $item_id; ?>">
                                        <span class="input-group-text"><i class="fa-regular fa-square icon-colored"></i></span>
                                    </a>
                                </td>
                                <?php if ($isImportant == 1): ?>
                                    <td>
                                        <div class="cell-container">
                                            <a href="edit_item.php?item_id=<?php echo $item_id; ?>&date=<?php echo urlencode($selected_date); ?>" class="full-cell-link-red">
                                                <?php echo $item; ?>
                                            </a>
                                        </div>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <div class="cell-container">
                                            <a href="edit_item.php?item_id=<?php echo $item_id; ?>&date=<?php echo urlencode($selected_date); ?>" class="full-cell-link">
                                                <?php echo $item; ?>
                                            </a>
                                        </div>
                                    </td>
                                <?php endif; ?>
                            <?php endif; ?>    
                        
                            <?php if ($has_date): ?> <!-- Si au moins un élément a une date, on affiche la colonne sinon non pour gagner de la place sur téléphone -->
                                <?php if (!empty($selected_date)): ?>
                                    <td class='icon-column'>
                                        <a href='edit_item.php?item_id=<?php echo $item_id; ?>&date=<?php echo urlencode($selected_date); ?>' style="text-decoration: none; color: inherit;">
                                            <?php if($is_date_passed_or_today): ?>
                                                <i class='fa fa-calendar-alt show-date red-calendar' data-date='<?php echo $selected_date; ?>'></i>
                                            <?php elseif(isset($days_remaining)): ?>
                                                <i class='fa fa-calendar-alt show-date icon-colored' data-date='<?php echo $selected_date; ?>'></i>
                                                <div class="days-remaining"><?php echo $days_remaining; ?></div>
                                            <?php else: ?>
                                                <i class='fa fa-calendar-alt show-date icon-colored' data-date='<?php echo $selected_date; ?>'></i>
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                <?php else: ?>
                                    <td class="icon-column"></td>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</body>

</html>
