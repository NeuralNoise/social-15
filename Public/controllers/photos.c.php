<?php 

$key = $_GET['photos'];

$this_user = null;
if (strcasecmp($_GET['user'], $u->username) !== 0) {
	$this_user = new person($_GET['user']);
}

/*
***********************
** =View
***********************
*/
$title = $u->full_name;
if (!empty($this_user) ) {
	$title = $this_user->full_name;
}
$script_b = "<script src='js/photos.js'></script>
           ";          
if ($key === 'all') {
	view('views/photos_all', array(
		'title' => $title,
		'this_user' => $this_user,
		'script_bottom' => $script_b,
		'xView' => $xView
		));
} else if ($key === 'albums') {
	view('views/photos_albums', array(
		'title' => $title,
		'this_user' => $this_user,
		'script_bottom' => $script_b,
		'xView' => $xView
		));
} else {
	header('Location:' . BASE_DIR);
}

?>