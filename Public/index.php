<?php 
 
require_once 'includes/social.php';
session_start();

if (isset($_GET['activation']) ) {
 	secure('get');
 	require_once parser('activation');

 } else if (isset($_SESSION['name']) && $_SESSION['pass']) {

	if (isset($_GET['dependencies']) ) {
	 	secure('get');
	 	require_once check_user();
	 	if ($user_ok) {
	 		require_once main_inc();
	 		require_once controller('dependencies');
	 	}
	 	
	 } else if (isset($_GET['upload']) ) {
	 	secure('get');
	 	require_once check_user();
	 	if ($user_ok) {
	 		require_once main_inc();
	 		require_once controller('upload');
	 	}

	 } else if (isset($_GET['logout']) ) {
	 	require_once parser('logout');

	 } else if (isset($_FILES['img']) ) {
	 	secure('post');
		require_once check_user();
		if ($user_ok) {
			require_once main_inc();
			require_once parser('photo');
		}

	 } else if (isset($_FILES['avatar']) ) {
	 	secure('post');
		require_once check_user();
		if ($user_ok) {
			require_once main_inc();
			require_once parser('photo');
		}

	 } else if (isset($_POST['ajax']) ) {
		secure('post');
		require_once check_user();
		if ($user_ok) {
			require_once main_inc();
			require_once parser($_POST['parser']);
		}

	} else if (isset($_GET['user']) && isset($_GET['notifications']) ) {
	 	secure('get');
	 	require_once check_user();
	 	if ($user_ok) {
	 		require_once main_inc();
	 		require_once controller('notifications');
	 	}

	 } else if (isset($_GET['message']) ) {
	 	secure('get');
	 	require_once check_user();
	 	if ($user_ok) {
	 		require_once main_inc();
	 		require_once controller('message');
	 	}

	} else if (isset($_GET['user']) && isset($_GET['edit']) ) {
	 	secure('get');
	 	require_once check_user();
	 	if ($user_ok) {
	 		require_once main_inc();
	 		require_once controller('edit');
	 	}

	} else if (isset($_GET['user']) && isset($_GET['photos']) ) {
		secure('get');
		require_once check_user();
		if ($user_ok) {
			require_once main_inc();
			require_once controller('photos');		
		}

	} else if (isset($_GET['user']) ) {
		secure('get');
		require_once check_user();
		if ($user_ok) {
			require_once main_inc();
			if (strcmp($u->username, $_GET['user']) === 0 ) {
				require_once controller('my');
			} else {
				require_once controller('user');
			}
		}
		
	} else if (isset($_GET['p_id']) ) {
		secure('get');
		$p_id = $_GET['p_id'];
		require_once check_user();
		if ($user_ok) {
			require_once main_inc();
			require_once controller('photo');
		}

	} else {
		require_once check_user();
		if ($user_ok) {	    
			header("Location: {$u->username}");
		} else {
			header('Location: parsers/logout.php');
		}

	}

} else if (isset($_COOKIE['n']) ) {
	secure('cookie');
	$sess = explode('//', $_COOKIE['n']);
	$_SESSION['name'] = $sess[0];
	$_SESSION['pass'] = $sess[1];
	$u = new person($_SESSION['name']);
	$u->dao->update(array(
	    'ip' => $_SERVER['REMOTE_ADDR'],
	    'last_login' => now(),
	    'online' => 1
    	));
	header('Refresh: 0');

} else {
	require_once controller('login-reg');
}

?>