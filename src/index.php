<?php

// Create the two needed tables
require('./create_tables.php');

?>

<!DOCTYPE html>
<html lang="fr">
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
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>

<body class="my-custom-class">

    <div id="blurContainer" style="display:none" class="blur-background"></div>  <!-- Conteneur pour le flou quand on affiche un popup -->
    <br>
    <!-- <h2 class="main-heading text-center">LISTEEM</h2>
    <hr style="width:100px; margin: auto;" /> -->

    <article class="card-body mx-auto" style="max-width: 500px;">
        <div style="text-align: center;">

            <p class="text-center">
                <br><br>
                <!-- <i class="fas fa-hourglass-half fa-spin"></i> -->
                <!-- If you prefer a standard spinner, you can use the following line instead of the above: -->
                <!-- <i class="fas fa-spinner fa-spin"></i> -->
                <img src="favicon.png" alt="Loading..." class="custom-spinner">
            </p>
            <br>
            <p>Checking language...</p>

            <br>
        </div> 
    </article>

    <!-- <script>
        setTimeout(function() {
            window.location.href = "home.php";  // Remplacez par l'URL de votre choix
        }, 2000);
    </script> -->

    <script>

        document.addEventListener("DOMContentLoaded", function() {
            // Obtenir la langue du navigateur
            var lang = window.navigator.language || window.navigator.userLanguage;
            console.log("lang:", lang);

            // Envoyer la langue au serveur (si nécessaire)
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'set_lang.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            // Ajouter le jeton CSRF à la requête
            var csrfToken = '<?php echo $_COOKIE['g_csrf_token']; ?>';
            xhr.send('lang=' + encodeURIComponent(lang) + '&g_csrf_token=' + encodeURIComponent(csrfToken));
        });
    
        setTimeout(function() {
            window.location.href = "login.php";  // Si je met pas de timeout, set_lang.php ci-dessous n'a pas le temps d'enregistrer la variable
        }, 1500);

    </script>

</body>
</html>
