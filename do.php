<?php
    require_once('database.php');
    require_once('tools.php');
    
    // This script will always return a json_encoded string
    header('Content-type: application/json');
    
    // We're going to do a thing.  That thing is in the GET parameter 'action'.
    $action = $_GET['action'];
    
    $result = "Did nothing.";

    switch ($action) {
        
        // Create a new game with a unique game_id, return the gameID
        case 'createGame':
            $game_id = generate_unique_id('game');
            
            $result = add_game($game_id);
            
            if ($result) {
                echo json_encode($game_id);
                exit();
            } else {
                echo json_encode(mysql_errno());
            }
            break;
        
        case 'pollPlayers':
            $game_id = $_GET['gameID'];
            
            $players = get_players($game_id);
            
            echo json_encode($players);
            exit();
            break;
        
        case 'addPlayer':
            $game_id = $_GET['gameID'];
            $player_name = $_GET['playerName'];
            
            $player_id = generate_unique_id('player');
            
            // Check to see what color, if any, is open
            if ($player_color = get_open_color($game_id)) {
                if (add_player($player_id, $game_id, $player_name, $player_color)) {
                    echo json_encode($player_id);
                }
            }
            exit();
            break;
            
        case 'getActiveEvent':
            $game_id = $_GET['gameID'];
            
            echo json_encode(get_active_event($game_id));
            break;
        
        case 'getPlayerEvent':
            $game_id = $_GET['gameID'];
            $player_id = $_GET['playerID'];
            
            echo json_encode(get_player_event($game_id, $player_id));
            break;
        
        case 'setPlayerDirective':
            $player_id = $_GET['playerID'];
            $directive = $_GET['directive'];
            
            echo json_encode(set_player_directive($player_id, $directive));
            break;
        case 'pollDirectives':
            $game_id = $_GET['gameID'];
            $campaign = $_GET['campaign'];
            $event = $_GET['event'];
            
            echo json_encode(check_directives($game_id, $campaign, $event));
            break;
        case 'advanceGame':
            $game_id = $_GET['gameID'];
            $result = $_GET['result'];
            
            echo json_encode(advance_game($game_id, $result));
            break;
    }
?>