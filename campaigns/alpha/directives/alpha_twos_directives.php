<?php
    // Passed an array called $directives with color => directive pairs
    // Directive is "none" by default
    // Set $result to "wait", "pass", "fail"
    // Result will be "wait" if no value is set
    
    // Alpha Twos
    // 2 pass, 2 fail
    
    $pass = 0;
    $vote = 0;
    $fail = 0;
    
    foreach($directives as $directive) {
        if ($directive == 'fail') {
            $vote++;
            $fail++;
        } else if ($directive == 'pass') {
            $pass++;
            $vote++;
        }
    }
    
    if ($vote == 4) $result = 'fail';
    if ($pass == 2 && $fail == 2) $result = 'pass';
?>