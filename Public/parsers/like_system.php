<?php 
extract($_POST);

if ($type === 'like') {
	Likes::create(array(
		'owner' => $u->username,
		'app' => $app,
		'on_id' => $on,
		'date' => now()
		));
	echo 'success';die;
}

if ($type === 'unlike') {
	$options = array('conditions' => array('owner = ? AND app = ? AND on_id = ?', $u->username, $app, $on));
	Likes::all($options)[0]->delete();
	echo 'success';die;
}
?>