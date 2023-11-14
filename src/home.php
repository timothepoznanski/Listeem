<?php

session_start();
require('./config.php');

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

    <article class="card-body mx-auto" style="max-width: 500px;">       
                
        <div style="text-align: center;">

            <br>

            <h4 class="main-heading text-center"><?php echo $var1 ?></h4>

            <hr style="margin: auto; margin-bottom: 30px" />

            <div class="d-flex" style="margin-bottom: 40px; margin-top: 45px;; padding-left:20px; padding-right:20px">
                <a href="my_lists.php" class="btn btn-outline-info w-100 mr-2"><?php echo $var2 ?></a>
                <!-- <a href="create_tables.php" class="btn btn-outline-info w-100"><?php echo $var3 ?></a> -->
            </div>

        </div>                 

    </article>

</body>
</html>