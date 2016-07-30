<?php

require_once('database.php');

function device_is_mobile() {
    $useragent = $_SERVER['HTTP_USER_AGENT'];

    return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
}

function generate_unique_id($table) {
    $seed = str_split('ABCDEFGHJKLMNPQRSTUVWXYZ');
    shuffle($seed); // probably optional since array_is randomized; this may be redundant
    $id = '';
    foreach (array_rand($seed, 5) as $k) $id .= $seed[$k];
    
    // CHECK TO SEE IF THIS GAME HAS BEEN CREATED TODO
    
    return $id;
}

function add_game($game_id) {   
    // Designate this game as waiting for players
    $campaign = 'none';
    $event = 'wait';
    
    $query = "INSERT INTO game (game_id, campaign, event)
    VALUES ('$game_id', '$campaign', '$event')";
    return mysql_query($query);
}

function get_players($game_id) {
    $query = "SELECT player_name, player_color
            FROM player
            WHERE game_id='$game_id'";
    $result = mysql_query($query);
    
    $players = array();
    
    while ($row = mysql_fetch_array($result, MYSQLI_ASSOC)) {
        $players[] = $row;
    }
    
    return $players;
}

function get_open_color($game_id) {
    $open_color = array(0 => 'red', 1 => 'yellow', 2 => 'blue', 3 => 'green');
    
    $players = get_players($game_id);
    $num_players = count($players);
    
    if (isset($open_color[$num_players])) return $open_color[$num_players];
    
    return false;
}

function add_player($player_id, $game_id, $player_name, $player_color) {
    $query = "INSERT INTO player (player_id, game_id, player_name, player_color)
    VALUES ('$player_id', '$game_id', '$player_name', '$player_color')";
    return mysql_query($query);
}

function get_player_data($player_id) {
    $query = "SELECT player_name, player_color, game_id
            FROM player
            WHERE player_id='$player_id'";
    $result = mysql_query($query);
    
    $player = mysql_fetch_array($result, MYSQLI_ASSOC);
    
    return $player;
}

function get_active_event($game_id) {
    $query = "SELECT campaign, event
            FROM game
            WHERE game_id='$game_id'";
    $result = mysql_query($query);
    
    $game = mysql_fetch_array($result, MYSQLI_ASSOC);
    
    require_once('campaigns.php');
    
    // Check to see if this game is started yet.  If not, start it.
    if ($game['event'] == 'wait') {
        // Default alpha start
        $campaign = 'alpha';
        $event = 'intro';
        if (update_game($game_id, $campaign, $event)) return $campaigns[$campaign][$event];
    } else {
        return $campaigns[$game['campaign']][$game['event']];
    }
}

function get_event_state($game_id) {
    $query = "SELECT event_state
            FROM game
            WHERE game_id='$game_id'";
    $result = mysql_query($query);
    
    $game = mysql_fetch_array($result, MYSQLI_ASSOC);
    
    return $game['event_state'];
}

function get_player_event($game_id, $player_id) {
    $query = "SELECT campaign, event
            FROM game
            WHERE game_id='$game_id'";
    $result = mysql_query($query);
    
    $game = mysql_fetch_array($result, MYSQLI_ASSOC);
    
    require_once('campaigns.php');
    
    // Check to see if this game is started yet.  If not, start it.
    if ($game['event'] == 'wait') {
        return 0;
    } else {
        return $campaigns[$game['campaign']][$game['event']];
    }
}

function update_game($game_id, $campaign, $event) {
    $query = "UPDATE game
            SET campaign='$campaign', event='$event'
            WHERE game_id='$game_id'";
            
    reset_game_directives($game_id);
    
    return mysql_query($query);
}

function set_player_directive($player_id, $directive) {
    $query = "UPDATE player
            SET player_directive='$directive'
            WHERE player_id='$player_id'";
    return mysql_query($query);
}

function reset_game_directives($game_id) {
    $query = "UPDATE player
            SET player_directive='wait'
            WHERE game_id='$game_id'";
    return mysql_query($query);
}

function get_game_directives($game_id) {
    $query = "SELECT player_color, player_directive
            FROM player
            WHERE game_id='$game_id'";
    $result = mysql_query($query);
    
    $directives = array();
    
    while ($row = mysql_fetch_array($result, MYSQLI_ASSOC)) {
        $directives[$row['player_color']] = $row['player_directive'];
    }
    
    return $directives;
}

function check_directives($game_id, $campaign, $event) {
    $directives = get_game_directives($game_id);
    $result = 'wait';
    
    require_once('campaigns/'.$campaign.'/directives/'.$campaign.'_'.$event.'_directives.php');
    
    return array('result' => $result, 'directives' => $directives);
}

function advance_game($game_id, $event_result = "fail") {
    $query = "SELECT campaign, event
            FROM game
            WHERE game_id='$game_id'";
    $result = mysql_query($query);
    
    $game = mysql_fetch_array($result, MYSQLI_ASSOC);
    
    require_once('campaigns.php');
    
    // Check to see if this game is started yet.  If not, start it.
    if ($game['event'] == 'wait') {
        // Default alpha start
        $campaign = 'alpha';
        $event = 'intro';
        if (update_game($game_id, $campaign, $event)) return $campaigns[$campaign][$event];
    } else {
        $next_event = $campaigns[$game['campaign']][$game['event']]['next_'.$event_result];
        
        update_game($game_id, $game['campaign'], $next_event);
        return $campaigns[$game['campaign']][$next_event];
    }
    
}

?>