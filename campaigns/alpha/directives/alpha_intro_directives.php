<?php
    // Passed an array called $directives with color => directive pairs
    // Directive is "none" by default
    // Set $result to "wait", "pass", "fail"
    // Result will be "wait" if no value is set
    
    // Alpha Intro
    // All 4 directives must be 'pass'
    
    $pass = 0;
    $vote = 0;
    
    foreach($directives as $directive) {
        if ($directive == 'fail') {
            $vote++;
        } else if ($directive == 'pass') {
            $pass++;
            $vote++;
        }
    }
    
    if ($vote == 4) $result = 'fail';
    if ($pass == 4) $result = 'pass';
?>