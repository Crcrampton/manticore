<?php

    // Events for alpha, find a better way to organize these later (by gametype, etc.)
    
    $events = array(
        'alpha_intro' => array(
            'campaign' => 'alpha',
            'title' => 'Alpha Playtest Introduction',
            'sound_before' => 'alpha_intro_before', // Do not include file exension, but make sure it's a .mp3 or .ogg
            'sound_pass' => 'alpha_intro_pass',
            'sound_fail' => 'alpha_intro_fail',
            'host_html' => 'alpha_intro_host.php',
            'host_js' => 'alpha_intro_host.js',
            'player_html' => 'alpha_intro_player.php',
            'player_js' => 'alpha_intro_player.js',
            'next_scene_pass' => '',
            'next_scene_fail' => '',
        );
    );
    
?>