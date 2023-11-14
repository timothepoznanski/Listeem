<?php
require('./config.php');
session_start();

//print("SESSION :\n");
//print_r($_SESSION['user']);


// récupération emoji
$defaultEmoji = "📋";  // Emoji de liste par défaut
$emojiValue = $defaultEmoji;
if(isset($_POST['clicked_emoji']) && !empty($_POST['clicked_emoji'])) {
    $emojiValue = $_POST['clicked_emoji'];
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

<script>

    window.onload = function() {
        var inputField = document.getElementById('input_id');
        
        // Récupère la valeur du stockage local et la définit comme valeur de l'input
        var savedValue = localStorage.getItem('savedInputValue');
        if (savedValue) {
            inputField.value = savedValue;
        }

        inputField.focus();

        // Écouteur d'événement pour sauvegarder la valeur de l'input dans le stockage local. Si je ne fais pas ça, quand on change l'emoji, on perd ce qui est dans l'input
        inputField.addEventListener('input', function() {
            localStorage.setItem('savedInputValue', this.value);
        });

        // Écouteur d'événement pour nettoyer le stockage local après la soumission du formulaire
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('savedInputValue');
        });
    };
 
</script>

<body class="my-custom-class">

    <div>
    <article class="card-body mx-auto" style="max-width: 500px;">

        <h4 class="card-title mt-3 text-center"><?php echo $var32 ?></h4><br>

        <form method="post" action="add_list_process.php">

            <input type="hidden" name="clicked_emoji" value="<?php echo htmlspecialchars($emojiValue, ENT_QUOTES, 'UTF-8'); ?>">

            <div class="input-wrapper">
                <a href="display_emojis.php?origin=create&emoji=<?php echo urlencode($emojiValue); ?>" class="btn btn-outline-info" style="text-decoration: none;">
                    <span id="emojiSpan"><?php echo $emojiValue; ?></span>
                </a>
                <input name="list_name" class="form-control input-focus-green ml-2" placeholder="<?php echo $var33 ?>" type="text" required="required" maxlength="40" id="input_id">
            </div>

            <br>

            <div class="form-group">
                <button name="sign_up" type="submit" class="btn btn-outline-info btn-block"><?php echo $var34 ?></button>
            </div>         

        </form>

        <a href="my_lists.php" style="text-decoration: none;"><button class="btn btn-outline-info btn-block"><?php echo $var35 ?></button></a><br>

        <div style="text-align: center;">
            <span style="color:lightcoral; font-size:16px;">
                <?php
                if(isset($_GET["msg"])){
                    echo $_GET['msg'];
                }
                ?>
            </span>
            </div>

    </article>
    </div>
</body>

</html>
