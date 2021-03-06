<?php
    // PHP for this game
    
    $color = $_GET['color'];
    
    switch ($color) {
        case 'red':
            $word = "QUEUE";
            break;
        case 'blue':
            $word = "CAL";
            break;
        case 'yellow':
            $word = "TOUR";
            break;
        case 'green':
            $word = "LEI";
            break;
    }
?>

<center><h1 style="font-size:3em"><?php print $word; ?></h1></center>

<?php if ($color == 'red') { ?>
<input id="word" type="text" placeholder="What's the word?" />

<script>
    // JS for this game (only red player)
    
    $(document).ready(function() {
        var checkTimes = 0;
        var correct = "CALCULATOR";
        var checkInterval = setInterval(function() {
            if ($('#word').val().toUpperCase() === correct) {
                clearInterval(checkInterval);
                setDirective("pass");
            }
            if (++checkTimes == 120) {
                setDirective("fail");
            }
        }, 500);
    });
</script>

<?php } ?>