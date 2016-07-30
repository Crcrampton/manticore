<?php

    // Campaign data organized $campaigns[campaign_id][event_id][data_id]
    
    $campaigns = array( // All campaigns
        'alpha' => array( // Alpha Campaign
            'intro' => array( // Intro Event
                'campaign' => 'alpha', // Don't forget this
                'id' => 'intro', // Unique (to this campaign)
                'title' => 'Alpha Playtest Introduction', // Title shown at top of host screen
                'delay_before' => 35000, // Milliseconds from the time the sound begins to play to when the host screen checks for directives. Should always be > length of the sound clip
                'delay_pass' =>  9000, // Milliseconds from the time the pass sound begins to play to when the next event starts.  Should always be > length of the sound clip
                'delay_fail' =>  9000, // Milliseconds from the time the fail sound begins to play to when the next event starts.  Should always be > length of the sound clip
                'next_pass' => 'twos', // ID of the next event after pass
                'next_fail' => 'twos', // ID of the next event after fail
            ),
            'twos' => array( // Twos
                'campaign' => 'alpha',
                'id' => 'twos',
                'title' => 'Alpha Playtest Twos',
                'delay_before' => 24000,
                'delay_pass' =>  10000,
                'delay_fail' =>  10000,
                'next_pass' => 'prime',
                'next_fail' => 'prime',
            ),
            'prime' => array( // Prime seconds
                'campaign' => 'alpha',
                'id' => 'prime',
                'title' => 'Alpha Prime Directive',
                'delay_before' => 18000,
                'delay_pass' =>  5000,
                'delay_fail' =>  5000,
                'next_pass' => 'word',
                'next_fail' => 'word',
            ),
            'word' => array( // Prime seconds
                'campaign' => 'alpha',
                'id' => 'word',
                'title' => 'Alpha Word',
                'delay_before' => 15000,
                'delay_pass' =>  5000,
                'delay_fail' =>  5000,
                'next_pass' => '',
                'next_fail' => '',
            )
        )
    );
    
?>