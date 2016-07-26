$(document).ready(function() {
    $('div#new-game').click(function() {
        $(this).html('<img src="images/ripple.svg" width="50px" />').unbind();
        createGameAndGo();
    });
});

function createGameAndGo() {
    $.get('do.php', { action : 'createGame'}, function(data) {
       window.location = '/host.php?gameID=' + data;
    }).fail(function(data) {
            setTimeout(createGameAndGo(), 3000);
    });
}