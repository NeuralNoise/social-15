<?php 

$photos = photo_DAO::album($_GET['user'], $_GET['albumView']);

if (empty($photos) ) {
	header('Location:' . BASE_DIR . 'index.php');
}

$my = false;
if (strcmp($_GET['user'], $u->username) === 0) {
	$my = true;
}
/*
***********************
** =View
***********************
*/
$title = mb_convert_case(replace_($_GET['albumView']), MB_CASE_TITLE, "UTF-8");
$script_b = "<script src='js/album.js'></script>";
$album = $_GET['albumView'];
view('views/album', array(
	'xView' => $xView,
	'photos' => $photos,
	'title' => $title,
	'album' => $album,
	'script_bottom' => $script_b,
	'my' => $my,
	'user' => $_GET['user']
	));

?>