<?php 

$type = isset($_GET['messages']) ? 'messages' : 'chat';

/*
***********************
** =Chat
***********************
*/
if ($type === 'chat') {
	if (strcmp($_GET['chat'], $u->username) === 0 ) {
		header('Location: ' . BASE_DIR);
	}
	try {
		$this_user = new person($_GET['chat']);	
	} catch (Exception $e) {
		header('Location: ' . BASE_DIR);
	}

	$options = array('conditions' => array('from_user = ? AND to_user = ? OR from_user = ? AND to_user = ?', $u->username, $this_user->username, $this_user->username, $u->username),
					 'order' => 'date');
	$messages = Chat::all($options);

	$me = array(
		'username' => $u->username,
		'full_name' => $u->full_name,
		'avatar' => $u->avatar
		);
	$you = array(
		'username' => $this_user->username,
		'full_name' => $this_user->full_name,
		'avatar' => $this_user->avatar
		);
	$me = json_encode($me);
	$you = json_encode($you);
}

/*
***********************
** =Messages
***********************
*/
if ($type === 'messages') {
	$options = array('conditions' => array('to_user = ?', $u->username),
					 'select' => 'from_user, to_user, msg, max(date) as date',
					 'order' => 'date desc',
					 'group' => 'from_user'
					 );
	$conversations = Chat::all($options);
	$script = "<script> 
					$(document).on('wsConnect', function(e){
						setTimeout(function(){
							e.socket.send(JSON.stringify( {type: 'msg_check'} ) );
						}, 1000);
						    
					}); 
				</script>";
}


/*
***********************
** =Views
***********************
*/
if ($type === 'messages') {
	view('views/messages', array(
		'xView' => $xView,
		'title' => 'Messages',
		'conversations' => $conversations,
		'script_bottom' => $script
		));
} else {
	view('views/chat', array(
		'xView' => $xView,
		'title' => 'Chat -- ' . $this_user->full_name,
		'script_bottom' => "<script src='js/chat.js'></script> <script src='js/vendor/jquery.autosize.min.js'></script>",
		'this_user' => $this_user,
		'messages' => $messages,
		'me' => $me,
		'you' => $you
		));
}

?>