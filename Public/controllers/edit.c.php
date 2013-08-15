<?php 


/*
***********************
** =View
***********************
*/
$script = "<script src='js/edit.js'></script>";

view('views/edit', array(
	'u' => $u,
	'script_bottom' => $script,
	'notifications' => $notifications,
	'title' => 'Edit Profile',
	'local' => $local
	));

?>