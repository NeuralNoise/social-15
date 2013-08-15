<?php 

if (isset($_SESSION['name']) && $_GET['logout']) {
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

if (isset($_SESSION['name']) && $_POST['logout']) {
	mkdir('test');
	try {
		$u->update(array('online' => '0'));
	} catch (Exception $e) {
		file_put_contents('log.txt', $e);
	}
	
	
}

?>