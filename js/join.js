$(document).ready(function() {
    $('div#join-game').on("tap", function() {
        $(this).html('<img src="images/ripple.svg" width="50px" />').unbind();
        addPlayerAndGo();
    });
});

function addPlayerAndGo() {
    var gameID = $('#game-id').val();
    var playerName = $('#player-name').val();
    
    if (gameID.length != 5 || playerName.length == 0) {
        alert("I'm sure that's wrong.");
    }
    
    $.get('do.php', { action : 'addPlayer', gameID : gameID, playerName : playerName }, function(data) {
        window.location = '/player.php?playerID=' + data;
    }).fail(function(data) {
            setTimeout(addPlayerAndGo(), 3000);
    });
}