var currentEvent;
var playerColor;
var eventOver;
var directiveTimer;

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
                // We've successfully received a new event - update the player and event variables
                currentEvent = event.title;
                eventOver = false;
                
                setTimeout(function() { $('#player-html').fadeOut(2000, function() {
                    $('#player-html').load('/campaigns/'+event.campaign+'/html/'+event.campaign+'_'+event.id+'_player.php?color='+playerColor);
                    $('#player-html').fadeIn(2000);
                    
                    // Begin polling for changes to the event (e.g. a trapdoor)
                    pollEventState();
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

function pollEventState() {
    setTimeout(function() {
        var gameID = $('#game').attr('data-gameid');
        var playerID = $('#game').attr('data-playerid');
        
        $.get('do.php', { action : 'getEventState', gameID : gameID, playerID : playerID }, function(data) {
            console.log(data);
            if (data === 'kill') {
                killPlayer();
                pollEvent();
            } else {
                // If the current event is over, start polling for the new event - otherwise keep polling for eventState changes
                if (eventOver) {
                    pollEvent();
                } else {
                    pollEventState();
                }
            }
        }).fail(function(data) {
            setTimeout(pollEventState(), 3000);
        });
    }, 500);
}

function setDirective(directive) {
    var gameID = $('#game').attr('data-gameid');
    var playerID = $('#game').attr('data-playerid');
    
    // Immediately lock the player out, we don't ever want to send more than one directive
    // window.navigator.vibrate(200);
    
    killPlayer();
    
    $.get('do.php', { action : 'setPlayerDirective', gameID : gameID, playerID : playerID, directive : directive }, function(event) {
        // Mark the event as over so we don't continue to poll for event changes - instead we'll poll for the new event
        eventOver = true;
    }).fail(function(data) {
        setTimeout(setDirective(), 3000);
    });
}

function setDirectiveTimer(seconds) {
    if (directiveTimer) { clearTimeout(directiveTimer); }
    
    var directiveTimer = setTimeout(function() {
        setDirective('fail');
    }, seconds * 100);
}

function killPlayer() {
    // Replaces all player HTML with the loading screen - called when a directive is set or a kill signal is sent by the host
    $('#player-html').html('<img src="images/ripple.svg" class="player-waiting">');
}