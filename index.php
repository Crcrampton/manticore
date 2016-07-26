<?php
    $scripts = array('splash');
    require_once("head.php");
    require_once("tools.php");
    
    if (device_is_mobile()) header('Location: /join.php');
?>

<body>
    <img id="splash-logo" src="images/manticore-logo.png" />
    <div class="button" id="new-game">+ New Game</div>
</body>