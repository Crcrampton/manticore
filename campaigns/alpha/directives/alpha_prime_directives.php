<?php
    // Passed an array called $directives with color => directive pairs
    // Player directive is "wait" by default
    // Set $result to "wait", "pass", "fail"
    // Result will be "wait" if no value is set
    
    // Prime Seconds
    // All 4 directives must be prime
    
    $primes = array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97);
    
    $total = 0;
    $prime = 0;
    
    foreach($directives as $directive) {
        if (in_array($directive, $primes)) {
            $total++;
            $prime++;
        } else if ($directive != "wait") {
            $total++;
        }
    }
    
    if ($total == 4) $result = "fail";
    if ($total == 4 && $prime == 4) $result = "pass";
?>