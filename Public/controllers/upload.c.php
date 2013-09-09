<?php 



/*
***********************
** =View
***********************
*/
$script_b = "<script src='js/upload.js'></script>";

$album = '';
if (isset($_GET['album']) ) {
	$album = mb_convert_case(replace_($_GET['album']), MB_CASE_TITLE, "UTF-8");;
}

view('views/upload', array(
	'xView' => $xView,
	'script_bottom' => $script_b,
	'album' => $album,
	'title' => 'Upload Photos'
	));

?>