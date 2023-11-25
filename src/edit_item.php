<?php

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
    exit();
}

$list_id = $_SESSION['l_id'];

if(isset($_GET["item_id"])){
    $item_id = $_GET["item_id"];
}

if (isset($_GET['date'])) {
    $date = $_GET['date'];
}


$query = "SELECT item, important from listsitems WHERE item_id='$item_id' ";
$result = mysqli_query($connect,$query);
if($result){
    $row = mysqli_fetch_assoc($result);

    $important = $row["important"];

    $encrypted_base64 = $row["item"];
    $encrypted = base64_decode($encrypted_base64);
    $decrypted = openssl_decrypt($encrypted, "AES-256-ECB", $key, OPENSSL_RAW_DATA);
    $actual_item = stripslashes($decrypted);

}else{
    echo "A problem has occurred...";
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
    
    <style>
        textarea {
            overflow: hidden;
            resize: none; /* si vous ne voulez pas que les utilisateurs redimensionnent manuellement le textarea */
        }
    </style>

</head>

<body class="my-custom-class">
    <div>
        <article class="card-body mx-auto" style="max-width: 400px;">
            <h4 class="card-title mt-3 text-center"><?php echo $var49 ?></h4>
            
            <form method="post" action="edit_item_process.php">
                <div class="form-group input-group">
                    <input type="hidden" name="item_id" value="<?php echo $item_id;?>">
                    <input type="hidden" name="new_item" value="<?php echo $new_item;?>">
                </div>
                
                <!-- on a ajouté un gestionnaire d'évenement pour empêcher l'utilisateur de sauter une ligne dans le textearea --> 
                <div class="form-group input-group">
                    <textarea id="dynamicTextarea" name="new_item" class="form-control input-focus-green" maxlength="300" onkeydown="return preventNewline(event)"><?php echo trim($actual_item); ?></textarea>
                </div>

                <label for="date"><?php echo $var58;?></label>
                <div class="form-group input-group">
                    <input type="date" id="datePicker" name="selected_date" value="<?php echo $date ?>" class="form-control input-focus-green">
                </div>

                <div style="text-align: center;">
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="important" id="importantCheckbox" <?php echo ($row['important'] == 1) ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="importantCheckbox">
                                <?php echo $var59; ?>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button name="edit_item" type="submit" class="btn btn-outline-info btn-block"><?php echo $var50 ?></button>
                </div> 
                
            </form>

            <form method="post" action="dashboard.php">
                <div class="form-group">
                    <button name="return_to_dashboard" type="submit" class="btn btn-outline-info btn-block"><?php echo $var35 ?></button>
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

        // On utilise javascript pour ajuster la taille de la textearea au fur et à mesure que l'on entre des données + on empêche de faire des sauts de ligne
        function adjustTextareaHeight(textarea) {
            textarea.style.height = 'auto'; // Réinitialisez d'abord la hauteur
            textarea.style.height = textarea.scrollHeight + "px";
        }

        // Événement à chaque fois que le contenu change
        document.getElementById('dynamicTextarea').addEventListener('input', function() {
            adjustTextareaHeight(this);
            this.value = this.value.replace(/\n/g, ' '); // Empêche les sauts de ligne
        });

        // Ajustez également la hauteur lors du chargement de la page
        window.addEventListener("DOMContentLoaded", (event) => {
            adjustTextareaHeight(document.getElementById('dynamicTextarea'));
        });

    </script>

</body>
</html>
