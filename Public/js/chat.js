$(document).ready(function(){
    $('textarea').autosize({append: "\n"});
    // $('textarea:last-child').blur();
});

function chatSend(to) {
	var inp = $('textarea'),
		msg = wsCode + 'to:' + to + ':' + inp.val(), // mvql284nf/to:bubo:message
		v = escape(inp.val() ),
		chat = $(".chat");
	socket.send(msg);
	chat.html(chat.html() + 'me: ' + v + '<br>');
	inp.val('');
}