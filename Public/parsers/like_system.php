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

if ($type === 'getLikers') {
	$options = array('conditions' => array('app = ? AND on_id = ?', $app, $on));
	$likers = Likes::all($options);
	$res = array();
	foreach ($likers as $like) {
		array_push($res, array('username' => $like->owner, 'full_name' => person_DAO::get_full_name($like->owner), 'avatar' => person_DAO::get_avatar($like->owner) ));
	}
	echo json_encode($res);die;
}
?>