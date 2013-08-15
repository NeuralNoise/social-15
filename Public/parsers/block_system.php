<?php 

if ($_POST['type'] === 'block') {
	try {
		if (empty($_POST['reason']) ) {
			$_POST['reason'] = null;
		}
		Blockedusers::create(array(
			'blocker' => $u->username,
			'blockee' => $_POST['blockee'],
			'block_date' => now(),
			'reason' => $_POST['reason']
			));
	} catch (Exception $e) {
		echo 'There was a problem. Try again later.';
		die();
	}

	echo 'success';
	die();
}

if ($_POST['type'] === 'unblock') {
	try {
		$cond = array('conditions' => array("blocker= ? AND blockee= ?",$u->username, $_POST['blockee']) );
		$row = Blockedusers::all($cond)[0];
		$row->delete();
	} catch (Exception $e) {
		echo 'There was a problem. Try again later.';
		die();
	}

	echo 'success';
	die();
}


?>