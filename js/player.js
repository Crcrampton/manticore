var currentEvent;
var playerColor;

$(document).ready(function() {
    pollEvent();
});

function pollEvent() {
    setTimeout(function() {
        var gameID = $('#game').attr('data-gameid');
        var playerID = $('#game').attr('data-playerid');
        var playerColor = $('#game').attr('data-playercolor');
        
        $.get('do.php', { action : 'getPlayerEvent', gameID : gameID, playerID : playerID }, function(event) {
            if (event && event.title !== currentEvent) {
                currentEvent = event.title;
                
                setTimeout(function() { $('#player-html').fadeOut(2000, function() {
                    $('#player-html').load('/campaigns/'+event.campaign+'/html/'+event.campaign+'_'+event.id+'_player.php?color='+playerColor);
                    $('#player-html').fadeIn(2000);
                });
                }, 1); // Do we want to wait, here?
            } else {
                pollEvent();
            }
        }).fail(function(data) {
            setTimeout(pollEvent(), 3000);
        });
    }, 500);
}

function setDirective(directive) {
    var gameID = $('#game').attr('data-gameid');
    var playerID = $('#game').attr('data-playerid');
    
    // Immediately lock the player out, we don't ever want to send more than one directive
    // window.navigator.vibrate(200);
    
    $('#player-html').html('<img src="images/ripple.svg" class="player-waiting">');
    
    $.get('do.php', { action : 'setPlayerDirective', gameID : gameID, playerID : playerID, directive : directive }, function(event) {
        pollEvent();
    }).fail(function(data) {
        setTimeout(setDirective(), 3000);
    });
}