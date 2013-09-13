wsCode = 'mvql284nf/';
function connect(){
	var chat = false;
	if (true) {
		
	}
    try {
		var host = "ws://localhost:8080";
		socket = new WebSocket(host);

		socket.onopen = function(e) {
			socket.send(wsCode + 'username:' + username); //19

		};

		socket.onmessage = function(msg){
			if ($("#chatWrap").html() ) {
				var chat = $(".chat");
				chat.html(chat.html() + 'from:' + msg.data + '<br>');
			}
		};

		socket.onclose = function() {

		};

	} catch(e) {
		alert('<p>Error' + e);
    }
}
$(document).ready(function() {
    if (!("WebSocket" in window) ) {
        alert('Oh no, you need a browser that supports WebSockets. How about Google Chrome?');
    } else {  
    //The user has WebSockets
		connect();
	}
});
