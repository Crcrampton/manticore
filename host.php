<?php
    $scripts = array('host', 'jquery.playSound');
    require_once("head.php");
    
    $game_id = $_GET['gameID'];
?>

<body>
    <div id="top">
        <img src="images/manticore-logo.png" class="top-logo" />
        <div id="game-status">Waiting for players...</div>
        <div id="game-working" style="display:none;"><img src="images/ripple.svg" width="50px" /></div>
    </div>
    
    <div id="game" data-gameid="<?php echo $game_id; ?>"></div>
    
    <div id="players">
        <div class="player" id="red"></div>
        <div class="player" id="yellow"></div>
        <div class="player" id="blue"></div>
        <div class="player" id="green"></div>
    </div>
    
    <div id="host-html">
        <p>Turn your <strong>SOUND</strong> up.</p>
        <p>On a <strong>separate</strong> device per player, go to <strong>manticore.us</strong> and join using the following game ID:</p>
        <h1><?php echo $game_id; ?></h1>
    </div>
</body>