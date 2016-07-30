<?php
    // Passed an array called $directives with color => directive pairs
    // Directive is "none" by default
    // Set $result to "wait", "pass", "fail"
    // Result will be "wait" if no value is set
    
    // Alpha Word
    // player.js does all the work here
    
    foreach($directives as $directive) {
        if ($directive == 'pass') $result = 'pass';
        if ($directive == 'fail') $result = 'fail';
    }
?>