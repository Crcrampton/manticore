<script>
    // JS for this game
    
    var time = 100;
    
    var tick = function() {
        time--;
        $('#clock').text(time);
        
        if (time == 0) {
            setDirective(100); // Make sure they fail
            clearInterval(tick);
        }
    }
    
    setInterval(tick, 500);
</script>

<center><h1 id="clock" style="font-size:3em">100</h1>
<div class="button" onclick="setDirective(time)">STOP</div>