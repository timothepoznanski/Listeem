<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Retrieval of the 'lang' cookie (lang is obtained by the script in index.php and sent via POST to set_lang.php)
if(isset($_COOKIE['lang'])) 
{
    $lang = $_COOKIE['lang'];
    if ($lang == 'fr-FR' || $lang == 'fr' || $lang =='fra' ) {
        $user_language_fr = True;
    } else {
        $user_language_fr = False;
    }
}

// APP CONNECTION
$app_password = getenv('APP_PASSWORD');

// BDD CONNECTION
$db_host = 'dbserver'; // Container name (from docker-compose file)
$db_username = getenv('MYSQL_USER');
$db_password = getenv('MYSQL_PASSWORD');
$db_name = getenv('MYSQL_DATABASE');
$db_port = '3306';

$connect=mysqli_connect($db_host, $db_username, $db_password, $db_name, $db_port);
if (!$connect) {
    die("BDD connection error : " . mysqli_connect_error());
}

// Key to encrypt and decrypt
$key = getenv('KEY_TO_ENCRYPT_DECRYPT_DB');


// Constants
$app_name_capital_min = "Listeem";

if ($user_language_fr) {
    // French
    $var1 = "LISTEEM";
    $var2 = "Mes listes";
    $var3 = "Créer les tables";
    $var19 = "Toutes les listes";
    $var20 = "Listes non-cachées";
    $var21 = "Listes cachées";
    $var22 = "Créer une nouvelle liste";
    $var23 = "Appuyez ici pour montrer seulement les listes non-cachées";
    $var24 = "Appuyez ici pour montrer seulement les listes cachées";
    $var25 = "Appuyez ici pour montrer toutes les listes même les cachées";
    $var26 = "Exporter toutes les listes";
    $var27 = "Accueil";
    $var28 = "Filtrez vos listes ici..";
    $var31 = "<br>Appuyez sur l'icone oeil pour changer la vue<br>ou appuyez sur l'icone plus pour créer une nouvelle liste.<br><br>";
    $var32 = "Créer une nouvelle liste";
    $var33 = "Nom de la liste";
    $var34 = "Créer";
    $var35 = "Annuler";
    $var36 = "Entrez un nom de liste s'il vous plait.";
    $var37 = "Ce nom de liste existe déjà.";
    $var38 = "Actions sur cette liste";
    $var39 = "Renommer cette liste";
    $var40 = "Exporter cette liste";
    $var41 = "Cette liste n'est pas cachée. Appuyer ici pour la cacher.";
    $var42 = "Cette liste a été marquée comme cachée. Appuyer ici pour la rendre visible.";
    $var43 = "Supprimer cette liste et tous ses éléments";
    $var44 = "Aller aux listes";
    $var45 = "Liste placée dans la vue des listes cachées";
    $var46 = "Ajoutez un éléments ici...";
    $var47 = "Ajouter";
    $var48 = "Êtes-vous sûr de vouloir supprimer cette liste et ses éléments définitivement ?";
    $var49 = "Modifier cet élément";
    $var50 = "Enregistrer";
    $var51 = "Supprimer cette liste";
    $var52 = "Exporter cette liste";
    $var53 = "Revenir à la liste";
    $var54 = "Cacher cette liste";
    $var55 = "Ne plus cacher cette liste";
    $var56 = "Choisissez une catégorie puis un emoji :";
    $var58 = "Date d'expiration de la tâche :";
    $var59 = "Tâche importante";
    $var60 = "Datez vos tâches";
    $var61 = "Mot de passe ?";

} else {
    // English
    $var1 = "LISTEEM";
    $var2 = "My lists";
    $var3 = "Create tables";
    $var19 = "All lists";
    $var20 = "Lists not hidden";
    $var21 = "Lists hidden";
    $var22 = "Create a new list";
    $var23 = "Click here to show only lists not hidden";
    $var24 = "Click here to show only hidden lists";
    $var25 = "Click here to show all lists even hidden ones";
    $var26 = "Export all lists";
    $var27 = "Home";
    $var28 = "Filter your lists here...";
    $var31 = "<br>Click on the eye icon to change view <br>or click on the plus icon to create a new list.<br><br>";
    $var32 = "Create a new list";
    $var33 = "List name";
    $var34 = "Create";
    $var35 = "Cancel";
    $var36 = "Please enter a list name.";
    $var37 = "This list name already exists.";
    $var38 = "Actions on this list";
    $var39 = "Rename this list";
    $var40 = "Export this list";
    $var41 = "This list is not hidden. Click here to hide it.";
    $var42 = "This list has been marked as hidden. Click here to un-hide it.";
    $var43 = "Remove this list and all its items";
    $var44 = "Go to lists view";
    $var45 = "List placed in the view of hidden lists.";
    $var46 = "Add an item here...";
    $var47 = "Add";
    $var48 = "Are you sure you want to delete this list and its items permanently?";
    $var49 = "Edit this item";
    $var50 = "Save";
    $var51 = "Delete this list";
    $var52 = "Export this list";
    $var53 = "Back to the list";
    $var54 = "Hide this list";
    $var55 = "Un-hide this list";
    $var56 = "Chose a category then chose an emoji :";
    $var58 = "Task expiration date :";
    $var59 = "Important task";
    $var60 = "Set tasks dates";
    $var61 = "Password?";
}
