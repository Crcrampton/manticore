<?php
    $scripts = array('jquery.vibrate', 'player');
    require_once("head.php");
    require_once("tools.php");
    
    $player_id = $_GET['playerID'];
    $player_data = get_player_data($player_id);
?>

<body class="mobile">
    <div class="player-top" style="border-bottom-color: <?php echo $player_data['player_color']; ?>"><img id="player-icon" src="images/manticore-icon.png" /><?php echo $player_data['player_name']; ?></div>
    
    <div id="game" data-gameid="<?php echo $player_data['game_id']; ?>" data-playerid="<?php echo $player_id; ?>"></div>
    
    <div id="player-html">
        <img src="images/ripple.svg" class="player-waiting">
    </div>
</body>