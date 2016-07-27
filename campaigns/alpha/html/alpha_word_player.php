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
<?php } ?>

<script>
    // JS for this game
    
    $(document).ready(function() {
        $('#word').change(function() {
            var correct = "CALCULATOR";
            if ($(this).val().toUpperCase() === correct) {
                setDirective("pass");
            }        
        });
    });
</script>