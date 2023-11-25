<?php
// Debug
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

session_start();
require('./config.php');

// Vérification si l'utilisateur est déjà connecté dans cette session
if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    // Redirection vers la page de connexion ou une page d'erreur
    header('Location: ./login.php');
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
    
    <style>
        /* ... Vos autres styles ... */
        .emoji-line {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            justify-content: center; /* Centrer horizontalement les emojis */
        }
        .emoji_categories {
            background: none;
            border: 1px solid;
            cursor: pointer;
            font-size: 1.5rem;
            transition: transform 0.1s;
            margin-right: 20px;
            border-radius: 5px;
        }
        .emoji {
            background: none;
            cursor: pointer;
            font-size: 1.5rem;
            transition: transform 0.1s;
            margin-right: 20px;
            border: none;
        }
        .emoji:hover {
            transform: scale(1.1);
        }
        .emoji-display {
            display: none; /* Cacher initialement les emojis */
        }
        .header1 {
            margin: 15px;
        }
    </style>
    <script>
        function displayEmojis(category) {
            let elements = document.getElementsByClassName('emoji-display');
            for (let element of elements) {
                element.style.display = 'none';  // Cacher tous les emojis
            }
            document.getElementById(category).style.display = 'flex';  // Afficher la catégorie sélectionnée
        }

        // Ajouter cette ligne pour afficher les emojis smileys par défaut
        window.onload = function() {
            displayEmojis('smileys');
        }
    </script>

</head>

<body style="text-align: center;">

<h6 class="header1"><?php echo $var56 ?></h6>

<br>

<!-- Categories -->
<div class="emoji-line">
    <button onclick="displayEmojis('listes')" class="emoji_categories">📋</button>
    <button id="defaultEmojis" onclick="displayEmojis('smileys')" class="emoji_categories">😄</button>
    <button onclick="displayEmojis('heart')" class="emoji_categories">❤️</button>
    <button onclick="displayEmojis('gestures')" class="emoji_categories">🖐️</button>
    <button onclick="displayEmojis('activities')" class="emoji_categories">⚽</button>
    <button onclick="displayEmojis('medias')" class="emoji_categories">🎸</button>
    <button onclick="displayEmojis('food')" class="emoji_categories">🍉</button>
    <button onclick="displayEmojis('animals')" class="emoji_categories">🐶</button>
    <button onclick="displayEmojis('plantEmojis')" class="emoji_categories">🌻</button>
    <button onclick="displayEmojis('objectEmojis')" class="emoji_categories">💡</button>
    <button onclick="displayEmojis('officeEmojis')" class="emoji_categories">🖥️</button>
    <button onclick="displayEmojis('clothingEmojis')" class="emoji_categories">👔</button>
    <button onclick="displayEmojis('transportAndPlacesEmojis')" class="emoji_categories ">🚚</button>
    <button onclick="displayEmojis('placesEmojis')" class="emoji_categories">🏝️</button>
    <!-- Ajoutez davantage d'icônes de catégories si nécessaire -->
</div>

<hr>

<div id="listes" class="emoji-display emoji-line">
    <?php
    $listes = ['📋', '📝', '🗒️', '⏰', '📌'];
    $action = 'create_list.php';  // action par défaut
    if (isset($_GET['origin']) && $_GET['origin'] === 'edit') {
        $action = "edit_list.php?list_name_from_get=" . urlencode(isset($_GET['list_name']) ? $_GET['list_name'] : '');
    }

    foreach ($listes as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>



<div id="smileys" class="emoji-display emoji-line">
    <?php
    $smileys = ["😀", "😁", "😂", "🤣", "😃", "😄", "😅", "😆", "😉", "😊",
    "😋", "😎", "😍", "🥰", "😘", "😗", "😙", "😚", "☺️", "🙂",
    "🤗", "🤩", "🤔", "🤨", "😐", "😑", "😶", "🙄", "😏", "😣",
    "😥", "😮", "🤐", "😯", "😪", "😫", "😴", "😌", "😛", "😜",
    "😝", "🤤", "😒", "😓", "😔", "😕", "🙃", "🤑", "😲", "☹️",
    "🙁", "😖", "🥵", "😞", "😟", "🥶", "🥴", "😤", "😢", "😭",
    "😦", "😧", "🥳", "😨", "😩", "🤯", "😬", "😰", "😱", "😳",
    "🤪", "😵", "😡", "🥺", "😠", "🤬", "😷", "🤒", "🤕", "🤢",
    "🤮", "🤧", "😇", "🤠", "🤥", "🤫", "🤭", "🧐", "🤓", "😈",
    "👿", "🤡", "👹", "👺", "💀", "☠️", "👻", "👽", "👾", "🤖",
    "💩", "🙊"];
    $action = 'create_list.php';  // default action
    if (isset($_GET['origin']) && $_GET['origin'] === 'edit') {
        $action = "edit_list.php?list_name_from_get=" . urlencode(isset($_GET['list_name']) ? $_GET['list_name'] : '');
    }
    foreach ($smileys as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="heart" class="emoji-display emoji-line">
    <?php
    $heart = [
        '💋', '💘', '💝', '💖', '💗', '💓', '💞', '💕', '💌', '❣️', '💔', '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '💟', '💍', '💎', '💐', '💒'
    ];
    foreach ($heart as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="people" class="emoji-display emoji-line">
    <?php
    $people = [
        '👶', '🧒', '👦', '👧', '🧑', '👨', '👱‍♂️', '🧔', '👩', '👱‍♀️', '🧓', '👴', '👵', '👨‍⚕️', '👩‍⚕️', '👨‍🎓', '👩‍🎓', '👨‍🏫', '👩‍🏫', '👨‍⚖️',
        '👩‍⚖️', '👨‍🌾', '👩‍🌾', '👨‍🍳', '👩‍🍳', '👨‍🔧', '👩‍🔧', '👨‍🏭', '👩‍🏭', '👨‍💼', '👩‍💼', '👨‍🔬', '👩‍🔬', '👨‍💻', '👩‍💻', '👨‍🎤', '👩‍🎤',
        '👨‍🎨', '👩‍🎨', '👨‍✈️', '👩‍✈️', '👨‍🚀', '👩‍🚀', '👨‍🚒', '👩‍🚒', '👮‍♂️', '👮‍♀️', '🕵️‍♂️', '🕵️‍♀️', '💂‍♂️', '💂‍♀️', '👷‍♂️', '👷‍♀️',
        '🤴', '👸', '👳‍♂️', '👳‍♀️', '👲', '🧕', '🤵', '👰', '🤰', '🤱', '👼', '🎅', '🤶', '🧙‍♂️', '🧙‍♀️', '🧚‍♂️', '🧚‍♀️', '👨‍🦰', '🧛‍♂️',
        '🧛‍♀️', '👨‍🦱', '👨‍🦳', '👨‍🦲', '🧜‍♂️', '🧜‍♀️', '🧝‍♂️', '👩‍🦰', '👩‍🦱', '🧝‍♀️', '👩‍🦳', '🧞‍♂️', '👩‍🦲', '🧞‍♀️', '🧟‍♂️', '🧟‍♀️',
        '🙍‍♂️', '🙍‍♀️', '🙎‍♂️', '🙎‍♀️', '🙅‍♂️', '🙅‍♀️', '🙆‍♂️', '🙆‍♀️', '💁‍♂️', '💁‍♀️', '🙋‍♂️', '🙋‍♀️', '🙇‍♂️', '🙇‍♀️', '🤦', '🤦‍♂️',
        '🤦‍♀️', '🤷', '🤷‍♂️', '🤷‍♀️', '💆‍♂️', '💆‍♀️', '💇‍♂️', '💇‍♀️', '👤', '👥', '🦸‍♂️', '🦸‍♀️', '🦹‍♂️', '🦹‍♀️', '👫', '👬', '👭',
        '👩‍❤️‍💋‍👨', '👨‍❤️‍💋‍👨', '👩‍❤️‍💋‍👩', '👩‍❤️‍👨', '👨‍❤️‍👨', '👩‍❤️‍👩', '👨‍👩‍👦', '👨‍👩‍👧', '👨‍👩‍👧‍👦', '👨‍👩‍👦‍👦', '👨‍👩‍👧‍👧',
        '👨‍👨‍👦', '👨‍👨‍👧', '👨‍👨‍👧‍👦', '👨‍👨‍👦‍👦', '👨‍👨‍👧‍👧', '👩‍👩‍👦', '👩‍👩‍👧', '👩‍👩‍👧‍👦', '👩‍👩‍👦‍👦', '👩‍👩‍👧‍👧', '👨‍👦',
        '👨‍👦‍👦', '👨‍👧', '👨‍👧‍👦', '👨‍👧‍👧', '👩‍👦', '👩‍👦‍👦', '👩‍👧', '👩‍👧‍👦', '👩‍👧‍👧'
    ];
    foreach ($people as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="gestures" class="emoji-display emoji-line">
    <?php
    $gestures = [
        '🦵', '🦶', '🤳', '💪', '👈', '👉', '☝️', '👆', '🖕', '👇', '✌️', '🤞', '🖖', '🤘', '🤙', '🖐️', '✋', '👌', '👍', '👎', '✊', '👊', '🤛', '🤜', '🤚',
        '👋', '🤟', '✍️', '👏', '👐', '🙌', '🤲', '🙏', '🤝', '👂', '👃', '👀', '👁️', '🧠', '👅', '👄'
    ];
    foreach ($gestures as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="activities" class="emoji-display emoji-line">
    <?php
    $activities = [
        '🚶‍♂️', '🚶‍♀️', '🏃‍♂️', '🏃‍♀️', '💃', '🕺', '👯‍♂️', '👯‍♀️', '🧖‍♂️', '🧖‍♀️', '🧗‍♂️', '🧗‍♀️', '🧘‍♂️', '🧘‍♀️', '🛌', '🕴️', '🗣️', '🤺', '🏇',
        '⛷️', '🏂', '🏌️‍♂️', '🏌️‍♀️', '🏄‍♂️', '🏄‍♀️', '🚣‍♂️', '🚣‍♀️', '🏊‍♂️', '🏊‍♀️', '⛹️‍♂️', '⛹️‍♀️', '🏋️‍♂️', '🏋️‍♀️', '🚴‍♂️', '🚴‍♀️',
        '🚵‍♂️', '🚵‍♀️', '🏎️', '🏍️', '🤸', '🤸‍♂️', '🤸‍♀️', '🤼', '🤼‍♂️', '🤼‍♀️', '🤽', '🤽‍♂️', '🤽‍♀️', '🤾', '🤾‍♂️', '🤾‍♀️', '🤹',
        '🤹‍♂️', '🤹‍♀️', '🎖️', '🏆', '🏅', '🥇', '🥈', '🥉', '⚽', '⚾', '🏀', '🏐', '🏈', '🏉', '🎾', '🎳', '🏏', '🏑', '🥎', '🏒', '🏓', '🏸',
        '🥊', '🥋', '🥏', '🥅', '⛸️', '🎣', '🥍', '🎿', '🛷', '🥌', '🎯', '🎱', '🧿', '🧩', '🧸', '🧵', '🧶'
    ];
    
    foreach ($activities as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="medias" class="emoji-display emoji-line">
    <?php
    $medias = [
        '📢', '📣', '📯', '🔔', '🎼', '🎵', '🎶', '🎙️', '🎚️', '🎛️', '🎧', '📻', '🎷', '🎸', '🎹', '🎺', '🎻', '🥁', '💽', '💿', '📀', '🎥', '🎞️', '📽️',
        '🎬', '📺', '📷', '📸', '📹', '📼'
    ];
    foreach ($medias as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="food" class="emoji-display emoji-line">
    <?php
    $food = [
        '🥭', '🍇', '🍈', '🍉', '🍊', '🍋', '🍌', '🍍', '🍎', '🍏', '🍐', '🍑', '🍒', '🥬', '🍓', '🥝', '🍅', '🥥', '🥑', '🍆', '🥔', '🥕', '🌽', '🌶️', '🥯',
        '🥒', '🥦', '🥜', '🌰', '🍞', '🥐', '🥖', '🥨', '🥞', '🧀', '🍖', '🍗', '🥩', '🥓', '🍔', '🍟', '🍕', '🌭', '🥪', '🌮', '🌯', '🥙', '🥚', '🧂',
        '🍳', '🥘', '🍲', '🥣', '🥗', '🍿', '🥫', '🍱', '🍘', '🍙', '🍚', '🍛', '🍜', '🥮', '🍝', '🍠', '🍢', '🍣', '🍤', '🍥', '🍡', '🥟', '🥠', '🥡',
        '🍦', '🍧', '🍨', '🍩', '🍪', '🧁', '🎂', '🍰', '🥧', '🍫', '🍬', '🍭', '🍮', '🍯', '🍼', '🥛', '☕', '🍵', '🍶', '🍾', '🍷', '🍸', '🍹', '🍺',
        '🍻', '🥂', '🥃', '🥤', '🥢', '🍽️', '🍴', '🥄', '🏺'
    ];
    
    foreach ($food as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>


<div id="animals" class="emoji-display emoji-line">
    <?php
    $animals = [
        '😺', '😸', '😹', '😻', '😼', '😽', '🙀', '😿', '😾', '🙈', '🙉', '🦝', '🐵', '🐒', '🦍', '🐶', '🐕', '🐩', '🐺', '🦊', '🐱', '🐈', '🦁', '🐯',
        '🐅', '🐆', '🐴', '🐎', '🦄', '🦓', '🦌', '🐮', '🦙', '🐂', '🐃', '🐄', '🐷', '🦛', '🐖', '🐗', '🐽', '🐏', '🐑', '🐐', '🐪', '🐫', '🦒',
        '🐘', '🦏', '🐭', '🐁', '🐀', '🦘', '🐹', '🦡', '🐰', '🐇', '🐿️', '🦔', '🦇', '🐻', '🐨', '🐼', '🐾', '🦃', '🐔', '🦢', '🐓', '🐣', '🐤',
        '🦚', '🐥', '🐦', '🦜', '🐧', '🕊️', '🦅', '🦆', '🦉', '🐸', '🐊', '🐢', '🦎', '🐍', '🐲', '🐉', '🦕', '🦖', '🐳', '🐋', '🐬', '🐟', '🐠',
        '🐡', '🦈', '🐙', '🐚', '🦀', '🦟', '🦐', '🦑', '🦠', '🐌', '🦋', '🐛', '🐜', '🐝', '🐞', '🦗', '🕷️', '🕸️', '🦂', '🦞'
    ];
    
    foreach ($animals as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="heart" class="emoji-display emoji-line">
    <?php
    $heart = [
        '💋', '💘', '💝', '💖', '💗', '💓', '💞', '💕', '💌', '❣️', '💔', '❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '💟', '💍', '💎', '💐', '💒'
    ];
    foreach ($heart as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="plantEmojis" class="emoji-display emoji-line">
    <?php
    $plantEmojis = [
        '🌸', '💮', '🏵️', '🌹', '🥀', '🌺', '🌻', '🌼', '🌷', '🌱', '🌲', '🌳', '🌴', '🌵', '🌾', '🌿', '☘️', '🍀', '🍁', '🍂', '🍃', '🍄'
    ];
    
    foreach ($plantEmojis as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>


<div id="objectEmojis" class="emoji-display emoji-line">
    <?php
    $objectEmojis = [
        '🦷', '🦴', '🛀', '👣', '💣', '🔪', '🧱', '🛢️', '⛽', '🛹', '🚥', '🚦', '🚧', '🛎️', '🧳', '⛱️', '🔥', '🧨', '🎗️', '🎟️', '🎫', '🧧', '🔮',
        '🎲', '🎴', '🎭', '🖼️', '🎨', '🎤', '🔍', '🔎', '🕯️', '💡', '🔦', '🏮', '📜', '🧮', '🔑', '🗝️', '🔨', '⛏️', '⚒️', '🛠️', '🗡️', '⚔️',
        '🔫', '🏹', '🛡️', '🔧', '🔩', '⚙️', '🗜️', '⚖️', '⛓️', '⚗️', '🔬', '🔭', '📡', '💉', '💊', '🚪', '🛏️', '🛋️', '🚽', '🚿', '🛁', '🛒',
        '🚬', '⚰️', '⚱️', '🧰', '🧲', '🧪', '🧴', '🧷', '🧹', '🧻', '🧼', '🧽', '🧯', '💠', '♟️'
    ];
    
    
    foreach ($objectEmojis as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="officeEmojis" class="emoji-display emoji-line">
    <?php
    $officeEmojis = [
        '💺', '🎮', '🕹️', '🎰', '📱', '📲', '☎️', '📞', '📟', '📠', '💻', '🖥️', '🖨️', '⌨️', '🖱️', '🖲️', '💾', '📔', '📕', '📖', '📗', '📘',
        '📙', '📚', '📓', '📒', '📃', '📄', '📰', '🗞️', '📑', '🔖', '🏷️', '💰', '💴', '💵', '💶', '💷', '💸', '💳', '💹', '💱', '✉️', '📧',
        '📨', '📩', '📤', '📥', '📦', '📫', '📪', '📬', '📭', '📮', '🗳️', '✏️', '✒️', '🖋️', '🖊️', '🖌️', '🖍️', '📝', '💼', '📁', '📂',
        '🗂️', '📅', '📆', '🗒️', '🗓️', '📇', '📈', '📉', '📊', '📋', '📌', '📍', '📎', '🖇️', '📏', '📐', '✂️', '🗃️', '🗄️', '🗑️', '🧾'
    ];
    
    
    foreach ($officeEmojis as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="clothingEmojis" class="emoji-display emoji-line">
    <?php
    $clothingEmojis = [
        '💅', '👓', '🕶️', '👔', '👕', '👖', '🧣', '🧤', '🧥', '🧦', '👗', '👘', '👙', '👚', '👛', '👜', '👝', '🛍️', '🎒', '👞', '👟', '👠', '👡', '👢',
        '👑', '👒', '🎩', '🎓', '🧢', '⛑️', '📿', '💄', '🌂', '☂️', '🎽', '🥽', '🥼', '🥾', '🥿', '🧺'
    ];
    
    
    foreach ($clothingEmojis as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="transportAndPlacesEmojis" class="emoji-display emoji-line">
    <?php
    $transportAndPlacesEmojis = [
        '🚂', '🚃', '🚄', '🚅', '🚆', '🚇', '🚈', '🚉', '🚊', '🚝', '🚞', '🚋', '🚌', '🚍', '🚎', '🚐', '🚑', '🚒', '🚓', '🚔', '🚕', '🚖', '🚗', '🚘',
        '🚙', '🚚', '🚛', '🚜', '🚲', '🛴', '🛵', '🚏', '🛣️', '🛤️', '⛵', '🛶', '🚤', '🛳️', '⛴️', '🛥️', '🚢', '✈️', '🛩️', '🛫', '🛬', '🚁',
        '🚟', '🚠', '🚡', '🛰️', '🚀', '🛸'
    ];   
    
    foreach ($transportAndPlacesEmojis as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<div id="placesEmojis" class="emoji-display emoji-line">
    <?php
    $placesEmojis = [
        '🌍', '🌎', '🌏', '🌐', '🗺️', '🗾', '🏔️', '⛰️', '🗻', '🏕️', '🏖️', '🏜️', '🏝️', '🏞️', '🏟️', '🏛️', '🏗️', '🏘️', '🏚️', '🏠', '🏡',
        '🏢', '🏣', '🏤', '🏥', '🏦', '🏨', '🏩', '🏪', '🏫', '🏬', '🏭', '🏯', '🏰', '🗼', '🗽', '⛪', '🕌', '🕍', '⛩️', '🕋', '⛲', '⛺',
        '🏙️', '🎠', '🎡', '🎢', '🎪', '⛳', '🗿'
    ];
    
    foreach ($placesEmojis as $emoji) {
        echo "<form action='$action' method='POST'>
                <button class='emoji' type='submit' name='clicked_emoji' value='$emoji'>$emoji</button>
              </form>";
    }
    ?>
</div>

<br><a href="javascript:history.back()" style="text-decoration: none;" class="btn btn-outline-info"><?php echo $var35 ?></a><br>

</body>
</html>
