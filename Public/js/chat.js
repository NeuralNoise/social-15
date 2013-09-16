$(document).ready(function(){
    $('textarea').autosize({append: "\n"});
});

var me = $.parseJSON($("#me").val());

function writing(to) {
	console.log(1)
	socket.send(JSON.stringify({
		type: 'writing',
		to: to
	}) );
}

function chatSend(to) {
	var inp = $('textarea'),
		v = inp.val().escapeHtml().replaceURL(),
		chat = $(".chat .mCSB_container"),
		card = prepareChatCard(me, v);

	chat.append(card);
	$('.chat').mCustomScrollbar("update");
	$(".chat").mCustomScrollbar("scrollTo","bottom",{
			scrollInertia:300
	});
	socket.send(JSON.stringify({
		type: 'send_message',
		to: to,
		msg: inp.val().replaceURL()
	}) );
	inp.val('');
}

(function($){
    $(window).load(function(){
        $(".chat").mCustomScrollbar({
        	theme: "dark-thick"
        });
        $(".chat").mCustomScrollbar("scrollTo","bottom",{
			scrollInertia:500
		});
    });
})(jQuery);