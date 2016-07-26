<?php
    $scripts = array('join');
    require_once("head.php");
?>

<body class="mobile">
    <img id="join-logo" src="images/manticore-logo.png" />
    <input type="text" class="join-data" id="game-id" placeholder="GAME ID" maxlength="5" />
    <input type="text" class="join-data" id="player-name" placeholder="PLAYER NAME" maxlength="10" />
    <div class="button" id="join-game">Join Game</div>
</body>