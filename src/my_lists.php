<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}
  

$query3 = "SELECT * FROM lists";
$stmt3 = $connect->prepare($query3);
$stmt3->execute();
$result3 = $stmt3->get_result();
$listExists = $result3->num_rows > 0; // Check if at least one list exists

if (!isset($_SESSION['eye_clicked'])) {
    $_SESSION['eye_clicked'] = 0;  // default view to show only list not hidden
}

if (isset($_GET['eye'])) {
    $_SESSION['eye_clicked'] = $_GET['eye'];
}

$show_hidden_lists = $_SESSION['eye_clicked'];

if ($show_hidden_lists == 1) {
    $query = "SELECT * FROM lists";
} elseif ($show_hidden_lists == 0) {
    $query = "SELECT * FROM lists WHERE hidden = 0";
} else {
    // When $show_hidden_lists is neither 0 nor 1, fetch all lists (including hidden ones)
    $query = "SELECT * FROM lists WHERE hidden = 1";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $app_name_capital_min; ?></title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link href="assets/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="assets/fontawesome/css/brands.css" rel="stylesheet">
    <link href="assets/fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.png" type="image/x-icon"/>
</head>

<body class="my-custom-class">

    <div style="margin-top: 35px; margin-bottom: 10px">

        <?php if ($show_hidden_lists == 1): ?>
            <h5 class="main-heading text-center"><?php echo $var19 ?></h5>
        <?php elseif ($show_hidden_lists == 0): ?>
            <h5 class="main-heading text-center"><?php echo $var20 ?></h5>
        <?php else: ?>
            <h5 class="main-heading text-center"><?php echo $var21 ?></h5>
        <?php endif; ?>

    </div>

    <article class="card-body mx-auto" style="max-width: 500px; ">

        <div style="text-align: center;">

            <div style="display: inline-block;">
                <a href="create_list.php" class="btn btn-outline-info"><span title="<?php echo $var22 ?>"><i class="fa-solid fa-square-plus"></i></span></a>
            </div>&emsp;&emsp;
            
            <?php if ($show_hidden_lists == 1): ?>
                <a href="javascript:void(0);" class="btn btn-outline-info" onclick="toggleEyeClicked(0)" style="text-decoration: none;">
                    <span title="<?php echo $var23 ?>">
                        <i class="fa fa-eye icon-menu"></i>
                    </span>
                </a>&emsp;&emsp;

            <?php elseif ($show_hidden_lists == 0): ?>
                <a href="javascript:void(0);" class="btn btn-outline-info" onclick="toggleEyeClicked(-1)" style="text-decoration: none;">
                    <span title="<?php echo $var24 ?>">
                        <i class="fa fa-eye-slash icon-menu"></i>
                    </span>
                </a>&emsp;&emsp;
            <?php else: ?>
                <a href="javascript:void(0);" class="btn btn-outline-info" onclick="toggleEyeClicked(1)" style="text-decoration: none;">
                    <span title="<?php echo $var25 ?>">
                        <i class="fa-solid fa-eye-low-vision icon-menu"></i>
                    </span>
                </a>&emsp;&emsp;
            <?php endif; ?>

            <div style="display: inline-block;">
                <a href="export_all_lists.php" class="btn btn-outline-info"><span title="<?php echo $var26 ?>"><i class="fa-solid fa-download icon-menu"></i></span></a>
            </div>&emsp;&emsp;

            <form id="eyeForm" method="get" style="display: none;">
                <input type="hidden" name="eye" value="">
            </form>

            <div style="display: inline-block;">
                <a href="home.php" class="btn btn-outline-info"><span title="<?php echo $var27 ?>"><i class="fa-solid fa-right-from-bracket icon-menu"></i></span></a>
            </div>
            
            <br><br>
            
            <div style='margin-bottom: 10px;'>
                <input type="text" id="myInput" class="filter-input" onkeyup="myFunction()" placeholder="<?php echo $var28 ?>" title="Filter lists"">
            </div>
            <!-- <br> -->

            <?php
                $stmt = $connect->prepare($query);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo '<table class="no-bullets" style="margin: 0 auto;">';
                
                    $counter = 1; 
                
                    // Collecter les données dans un tableau
                    while ($row = $result->fetch_assoc()) {
                        $list_name = trim($row["list_name"]); 
                        $list_emoji = $row["list_emoji"]; 
                        $listData[] = $row;
                    }

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
                    
                    
                    // Parcourir le tableau trié et afficher les résultats (avec l'emoji)
                    foreach ($listData as $row) {
                        $list_name = $row["list_name"];
                        $list_emoji = $row["list_emoji"];
                        $listNameUrlEncoded = urlencode($list_name);
                        $listNameDisplayed = $list_emoji . "&nbsp;&nbsp;&nbsp;" . $list_name; // Attention j'ai mis deux espaces entre l'emoji et le nom de la liste juste pour l'affichage

                        // Ajout d'une ligne entre les lignes que je fais disparaître pour avoir un effet de séparation entre les lignes des listes pointer-events none pour ne pas pouvoir cliquer dessus
                        echo "<tr style='pointer-events: none;'>"; 
                        echo "<td style='padding: 0; border: 0px; box-shadow: None;'><div style='min-height: 10px !important;'></div></td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td style='text-align: left;'>";
                        if ($row["hidden"] == 1) {
                            echo "<a href='dashboard.php?list_name=$listNameUrlEncoded' class='full-width-link'>";
                            echo "<span><em>$listNameDisplayed</em></span>";
                            echo "</a>";
                        } else {
                            echo "<a href='dashboard.php?list_name=$listNameUrlEncoded' class='full-width-link'>";
                            echo "<span>$listNameDisplayed</span>";
                            echo "</a>";
                        }
                        echo "</td>";
                        echo "</tr>";

                        $counter++;
                    }
                
                    echo "</table>";                    
                }
                    else {
                    echo $var31;                    
                }
            ?>
        </div>

    </article>

</body>
<script>

    // Filtre
    function myFunction() {
        var input, filter, table, tr, td, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.querySelector("table.no-bullets");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Changer ici pour dire sur quelle colonne filtrer (0 = colonne numéro, 1 colonne nom)
            if (td) {
                if (td.textContent.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function toggleEyeClicked(newValue) {
        var eyeForm = document.getElementById('eyeForm');
        eyeForm.elements['eye'].value = newValue;
        eyeForm.submit();
    }

</script>

</html>
