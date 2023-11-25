<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

$listName = $_SESSION["l_name"];
$emoji = $_SESSION["l_emoji"];

if (isset($_GET['list_name_from_get']) && mb_strlen($_GET['list_name_from_get']) > 0) {
    $listName = isset($_GET['list_name_from_get']) ? urldecode($_GET['list_name_from_get']) : '';
    $listName = trim($listName);
}

$list_id = $_SESSION["l_id"];
$list_old_name = $_SESSION["l_name"];

// Vérifiez si un nouvel emoji est passé en tant que paramètre POST
if (isset($_POST['clicked_emoji'])) {
    $emoji = $_POST['clicked_emoji'];  // Remplacez l'emoji existant par le nouvel emoji
    $_SESSION["l_emoji"] = $emoji;  // Mettre à jour la session avec le nouveau emoji
}

$stmt = mysqli_prepare($connect, "SELECT hidden FROM lists WHERE list_id = ?");
mysqli_stmt_bind_param($stmt, "i", $list_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $hidden = $row['hidden'];
    
} else {
    header("location:home.php?msg=This list doesn't exist");
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

<style>
    textarea {
        overflow: hidden; /* Pour enlever l'ascenseur */
        resize: none; /* si vous ne voulez pas que les utilisateurs redimensionnent manuellement le textarea */
    }
</style>

<script>

// Pour focus sur l'input pour la création 
window.onload = function() {
    var inputField = document.getElementById('input1');
    inputField.focus();
};
 
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var emojiLink = document.getElementById('emojiLink');
        var inputField = document.getElementById('input1');
        var emojiSpan = document.getElementById('emojiSpan');

        emojiLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior

            var listNameValue = inputField.value;
            var listEmojiValue = emojiSpan.textContent; // Get the emoji text content
            var newUrl = "display_emojis.php?origin=edit" + '&list_name=' + encodeURIComponent(listNameValue) + '&list_emoji=' + encodeURIComponent(listEmojiValue);
            
            window.location.href = newUrl; // Redirect to the new URL with GET parameters
        });
    });
</script>

<body class="my-custom-class">

    <div>
        <article class="card-body mx-auto" style="max-width: 400px;">
            <h4 class="card-title mt-3 text-center"><?php echo $var38 ?></h4>
            <br>
            
            <form method="post" action="edit_list_process.php">
                <div class="form-group">
                    <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                    <input type="hidden" name="list_old_name" value="<?php echo htmlspecialchars($_SESSION["l_name"], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="clicked_emoji" value="<?php echo htmlspecialchars($emoji, ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="input-wrapper">
                        <?php if(!empty($emoji)): ?>
                            <a href="display_emojis.php?origin=edit" id="emojiLink" class="btn btn-outline-info" style="text-decoration: none;">
                                <span id="emojiSpan"><?php echo $emoji; ?></span>
                            </a>
                        <?php endif; ?>
                        <input id='input1' name="list_name" class="form-control input-focus-green ml-2 mr-2" type="text" required="required" maxlength="40" value="<?php echo $listName; ?>">
                        
                        <button type="submit" title="<?php echo $var44 ?>" class="btn btn-outline-info">
                            <input type="hidden" name="full_list_name" id="fullListName" value="">
                            <i class="fa-solid fa-floppy-disk"></i>
                        </button>
                    </div>
                </div>
            </form>

            <form method="post" action="export_a_list.php">
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-info btn-block btn-icon-left">
                        <i class="fa-solid fa-download icon-spacing"></i> 
                        <span class="text-colored"><?php echo $var52 ?></span>
                    </button>
                </div> 
            </form>

            <?php if ($hidden == 0): ?>
                <form method="get" action="hide_list_process.php">
                    <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-info btn-block btn-icon-left">
                            <i class="fa-solid fa-eye-slash icon-spacing"></i> 
                            <span class="text-colored"><?php echo $var54 ?></span>
                        </button>
                    </div> 
                </form>
            <?php else: ?>
                <form method="get" action="hide_list_process.php">
                    <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-info btn-block btn-icon-left">
                            <i class="fa-solid fa-eye icon-spacing"></i> 
                            <span class "text-colored"><?php echo $var55 ?></span>
                        </button>
                    </div> 
                </form>
            <?php endif; ?>

            <form method="get" action="delete_list_process.php">
                <input type="hidden" name="list_id" value="<?php echo $list_id; ?>">
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-danger btn-block btn-icon-left" onclick="return confirmDelete('<?php echo addslashes($var48); ?>');">
                        <i class="fa fa-trash-alt icon-spacing"></i>
                        <span class="text-colored"><?php echo $var51 ?></span>
                    </button>
                </div> 
            </form>

            <form method="post" action="dashboard.php">
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-info btn-block btn-icon-left">
                        <i class="fa-solid fa-right-from-bracket icon-spacing"></i> 
                        <span class="text-colored"><?php echo $var53 ?></span>
                    </button>
                </div> 
            </form>

            
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

    <script>

        function confirmDelete(message) {
            return confirm(message);
        }
        
    </script>
        
</body>
</html>
