<?php 

$key = $_GET['photos'];

$this_user = clone $u;
$my = true;
if (strcasecmp($_GET['user'], $u->username) !== 0) {
	$this_user = new person($_GET['user']);
	$my = false;
}


/*
***********************
** =View
***********************
*/
$title = $this_user->full_name;

$script_b = "<script src='js/photos.js'></script>";          

// All Photos View
$all_photos = photo_DAO::all_photos($this_user->username);

// Albums View
$albums = photo_DAO::albums($this_user->username);

if ($key === 'all') {
	view('views/photos_all', array(
		'title' => $title,
		'this_user' => $this_user,
		'script_bottom' => $script_b,
		'xView' => $xView,
		'my' => $my,
		'all_photos' => $all_photos
		));

} else if ($key === 'albums') {
	view('views/photos_albums', array(
		'title' => $title,
		'this_user' => $this_user,
		'script_bottom' => $script_b,
		'xView' => $xView,
		'albums' => $albums,
		'my' => $my
		));

} else {
	header('Location:' . BASE_DIR);
}

?>