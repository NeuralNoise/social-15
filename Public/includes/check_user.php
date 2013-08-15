<?php 

if (isset($_SESSION['name']) ) {
	secure('session');
	$user_ok = false;
	$user = User::find($_SESSION['name']);
	if ($user !== null) {
		if ($user->activated === 0) {
			header('Location: ' . BASE_DIR . 'message/not_active');
		}

		if (strcmp($_SESSION['pass'], $user->password) === 0) {
			$user_ok = true;

	        global $u;
			$u = new person($user->username);
		}
	} 
} else {
	header('Location: ' . BASE_DIR . 'message/log_in');
}


?>