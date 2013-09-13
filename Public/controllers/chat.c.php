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


	
}

/*
***********************
** =Views
***********************
*/
if ($type === 'messages') {
	view('views/messages', array(
		'xView' => $xView,
		'title' => 'Messages'));
} else {
	view('views/chat', array(
		'xView' => $xView,
		'title' => 'Chat -- ' . $this_user->full_name,
		'script_bottom' => "<script src='js/chat.js'></script> <script src='js/jquery.autosize.min.js'></script>",
		'this_user' => $this_user));
}

?>