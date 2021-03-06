var activeEvent;
var advanceReady = false;

$(document).ready(function() {
    pollPlayers();
});

function pollPlayers() {
    setTimeout(function() {
        var gameID = $('#game').attr('data-gameid');
    
        $('#game-working').show();
        $.get('do.php', { action : 'pollPlayers', gameID : gameID }, function(data) {
           $('#game-working').hide();
           updatePlayers(data);
           if (data.length < 4) {
            pollPlayers();
           } else {
            updateStatus("Game full.");
            advanceGame(gameID);
           }
        }).fail(function(data) {
            setTimeout(pollPlayers(), 3000);
        });
    }, 500);
}

function updatePlayers(players) {
    $.each(players, function(i, player) {
       var playerColor = player.player_color;
       if ($('#'+playerColor).html().length == 0) {
        $('#'+playerColor).css('border-bottom-color', playerColor);
        $('#'+playerColor).html(player.player_name);
        $.playSound('/sounds/join');
       }
    });
}

function resetPlayerSet() {
    $('#players .player').removeClass('set');
    $('#players .player').css('color', '#eeeeee');
    $('#players .player').css('border-bottom-color', '#999');
}

function updatePlayerSet(directives) {
    $.each(directives, function(playerColor, directive) {
       if (directive !== 'wait') {
        if (!$('#'+playerColor).hasClass('set')) {
            $('#'+playerColor).css('color', '#333');
            $('#'+playerColor).css('border-bottom-color', playerColor);
            $.playSound('/sounds/playerSet');
            $('#'+playerColor).addClass('set');
        }
       }
    });
}

function updateStatus(status) {
    $('#game-status').text(status);
}

function advanceGame(gameID, result) {
    $('#game-working').show();
    
    // Poll the game for the active event, execute it
    $.get('do.php', { action : 'advanceGame', gameID : gameID, result : result }, function(event) {
        $('#game-working').hide();
        
        activeEvent = event;
        
        $.playSound('/campaigns/'+activeEvent.campaign+'/sounds/'+activeEvent.campaign+'_'+activeEvent.id+'_before');
        
        updateStatus(event.title);
        
        activeEvent = event;
        
        $('#host-html').fadeOut(1000, function() {
            $('#host-html').load('/campaigns/'+event.campaign+'/html/'+event.campaign+'_'+event.id+'_host.php');
            $('#host-html').fadeIn(1000);
        });
        
        // Start polling for player directives immediately.
        advanceReady = false;
        resetPlayerSet();
        pollDirectives();
        setTimeout(function() {
            // After the read is over, make sure pollDirectives is ready to advance the game
            advanceReady = true;
        }, event.delay_before);
    }).fail(function(data) {
            setTimeout(advanceGame(), 3000);
    });
}

function pollDirectives() {
    setTimeout(function() {
        var gameID = $('#game').attr('data-gameid');
    
        $('#game-working').show();
        $.get('do.php', { action : 'pollDirectives', gameID : gameID, campaign : activeEvent.campaign, event : activeEvent.id }, function(data) {
            console.log(JSON.stringify(data));
            updatePlayerSet(data.directives);
            var result = data.result;
           if (result === 'wait' || advanceReady == false) {
            pollDirectives();
           } else if (result === 'pass') {
            $.playSound('/campaigns/'+activeEvent.campaign+'/sounds/'+activeEvent.campaign+'_'+activeEvent.id+'_pass');
            $('#host-html').fadeOut(1000, function() {
                $('#host-html').load('/campaigns/'+activeEvent.campaign+'/html/'+activeEvent.campaign+'_'+activeEvent.id+'_host_pass.php');
                $('#host-html').fadeIn(1000);
            });
            setTimeout(function() {
                advanceGame(gameID, 'pass');
            }, activeEvent.delay_pass);
           } else if (result === 'fail') {
            $.playSound('/campaigns/'+activeEvent.campaign+'/sounds/'+activeEvent.campaign+'_'+activeEvent.id+'_fail');
            $('#host-html').fadeOut(1000, function() {
                $('#host-html').load('/campaigns/'+activeEvent.campaign+'/html/'+activeEvent.campaign+'_'+activeEvent.id+'_host_fail.php');
                $('#host-html').fadeIn(1000);
            });
            setTimeout(function() {
                advanceGame(gameID, 'fail');
            }, activeEvent.delay_fail);
           }
        }).fail(function(data) {
            setTimeout(pollDirectives(), 3000);
        });
    }, 500);
}
