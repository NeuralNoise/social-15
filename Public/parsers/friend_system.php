<?php 

if ($_POST['type'] === 'accept') {
	extract($_POST);
	$now = now();
	try {
		$cond = array('conditions' => array('user1 = ? AND user2 = ? AND accepted = "0"', $user1, $u->username) );
		$fr = Friends::all($cond)[0];
		$fr->accepted = '1';
		$fr->save();

		$message = person_DAO::get_full_name($u->username) . ' accepted your friend request.';
		Notifications::create(array(
			'username' => $user1,
			'initiator' => $u->username,
			'message' => $message,
			'app' => 'fr_request',
			'path' => BASE_DIR . $u->username,
			'date' => $now
			));
	} catch (Exception $e) {
		echo 'There was a problem. Try again later.';
		die();
	}
	echo 'success';
	die();
}

if ($_POST['type'] === 'add') {
	extract($_POST);
	$now = now();
	try {
		Friends::create(array(
			'user1' => $u->username,
			'user2' => $user2,
			'date_made' => $now
			));
		$message = person_DAO::get_full_name($u->username) . ' sent you a friend request.';
		Notifications::create(array(
			'username' => $user2,
			'initiator' => $u->username,
			'message' => $message,
			'app' => 'fr_request',
			'path' => BASE_DIR . $u->username,
			'date' => $now
			));
	} catch (Exception $e) {
		echo 'There was a problem. Try again later.';
		die();
	}
	echo 'success';
	die();
}

if ($_POST['type'] === 'rem') {
	extract($_POST);
	try {
		$cond = array('conditions' => array('user1 = ? AND user2 = ? AND accepted="1" OR user1 = ? AND user2 = ? AND accepted="1"', $u->username, $user2, $user2, $u->username) );
		$row = Friends::all($cond)[0];
		$row->delete();
	} catch (Exception $e) {
		echo 'There was a problem. Try again later.';
		die();
	}

	echo 'success';
	die();
}

if ($_POST['type'] === 'revoke') {
	extract($_POST);
	try {
		$cond = array('conditions' => array('user1 = ? AND user2 = ? AND accepted="0" OR user1 = ? AND user2 = ? AND accepted="0"', $u->username, $user2, $user2, $u->username) );
		$row = Friends::all($cond)[0];
		$row->delete();

		$cond = array('conditions' => array('username = ? AND initiator = ? AND app = "fr_request"', $user2, $u->username));
		$row = Notifications::all($cond)[0];
		$row->delete();
	} catch (Exception $e) {
		echo 'There was a problem. Try again later.';
		die();
	}

	echo 'success';
	die();
}
?>