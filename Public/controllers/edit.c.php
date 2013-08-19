<?php 


/*
***********************
** =View
***********************
*/
$script = "<script src='js/edit.js'></script>";

view('views/edit', array(
	'script_bottom' => $script,
	'title' => 'Edit Profile',
	'xView' => $xView
	));

?>