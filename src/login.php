<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (isset($_SESSION['auth']) || $_SESSION['auth'] == true) {
    header('Location: ./home.php');
    exit();
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

    <article class="card-body mx-auto" style="max-width: 500px;">       
                
        <div style="text-align: center;">

        <br>
        <br>
        <h1 style="text-align:center"><img width="30" height="30" class="imagelogin" src="favicon.ico"></h1>
        <br>
        <form action="login_action.php" method="POST">
            <h4><input autocomplete="off" spellcheck="false" id="pass" style="text-align:center; border: none; outline: none;" name="pass" type="password" placeholder="<?php echo $var61 ?>"></h4>
        </form>

        </div>                 

    </article>

</body>
</html>