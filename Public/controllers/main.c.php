<?php 



/*
***********************
** =View
***********************
*/
$script = "<script src='js/main.js'></script>";

view('views/main', array(
	'title' => ucfirst($u->username ),
	'script_bottom' => $script,
	'u' => $u,
	'notifications' => $notifications
	));

?>