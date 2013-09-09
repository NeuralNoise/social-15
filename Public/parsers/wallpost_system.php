<?php 

extract($_POST);

if ($type == 'add') {
	$from_user = $u->username;
	$now = now();
	$post = Wallposts::create(array(
				'body' => $body,
				'on_user' => $on_user,
				'from_user' => $from_user,
				'date' => $now
				));
	if (strcmp($from_user, $on_user) !== 0) {
		Notifications::create(array(
				'username' => $on_user,
				'initiator' => $from_user,
				'message' => $u->full_name . " posted on your wall.",
				'app' => 'wallpost',
				'on_id' => $post->w_id,
				'path' => './post/' . $post->w_id,
				'date' => $now
				));
	}

	$result = array(
		'username' => $from_user,
		'fullName' => $u->full_name,
		'avatar' => $u->avatar,
		'date' => $now,
		'w_id' => $post->w_id,
		'body' => $body,
		'thisUser' => $on_user
		);
	
	echo json_encode($result);die;
}

?>