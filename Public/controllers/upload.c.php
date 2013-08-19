<?php 



/*
***********************
** =View
***********************
*/
$script_b = "<script src='js/upload.js'></script>";

view('views/upload', array(
	'xView' => $xView,
	'script_bottom' => $script_b
	));

?>