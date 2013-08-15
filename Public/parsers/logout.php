<?php 

if (isset($_SESSION['name']) ) {
	$user = User::find_by_username($_SESSION['name']);
	if ($user !== null) {
		$user->online = 0;
		$user->save();
	}
	
	setcookie('n', '', time() - 500, '/');
	session_destroy();
	$_SESSION = [];
	header('Location: .');
} else {
	header('Location: .');
}


?>