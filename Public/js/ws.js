function connect() {
    try {
		var host = "ws://localhost:8080";
		socket = new WebSocket(host);

		socket.onopen = function(e) {
			socket.send(JSON.stringify({
				type: 'set_user',
				username: username
			}) );

		};

		socket.onmessage = function(e) {
			var data = $.parseJSON(e.data);
			if ($("#chatWrap").html() ) {
				var chat = $(".chat .mCSB_container");
				console.log(data);
				if (data.writing) {
					console.log(1)
					var writing = $("#writing");
					writing.html('Writing...');
					setTimeout(function() {
						writing.html('');
					}, 1500);
				} else {
					var	you = $.parseJSON($("#you").val()),
						card = prepareChatCard(you, data.msg);

					chat.append(card);
					$('.chat').mCustomScrollbar("update");
					$(".chat").mCustomScrollbar("scrollTo", "bottom", {
							scrollInertia:300
					});
				}
				

			} else {
				if (!data.writing) {
					var snd = new Audio("chat_alert.mp3");
					snd.play();
				}
				
			}
			if (!data.writing) {
				$('#headerMessagesNone').attr('id', 'headerMessagesNew');
				var nMsg = $("#numMessages");
				nMsg.html(data.nMsg);
				nMsg.show();
			}
			
		};

		socket.onclose = function() {

		};

		$.event.trigger({
			type: "wsConnect",
			socket: socket
		});

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
