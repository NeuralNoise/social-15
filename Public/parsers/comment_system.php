<?php 

if (isset($_POST['add_comment']) ) {
	extract($_POST);
	$owner = $u->username;
	$c = new comment;
	$c->set_all($body, $owner, now(), $on, $app);
	$new_c = $c->dao->create();
	$now = now();

	$commenters = $c->dao->commenters();
	foreach ($commenters as $commenter) {
		if (strcmp($commenter->owner, $owner) !== 0 && strcmp($commenter->owner, $user) !== 0 ) {
			Notifications::create(array(
				'username' => $commenter->owner,
				'initiator' => $owner,
				'message' => $u->full_name . " commented on a ". $app .".",
				'app' => 'photo',
				'on_id' => $on,
				'path' => $path,
				'date' => $now
				));
		}
	}
	if (strcmp($owner, $user) !== 0 ) {
		$message = $u->full_name . " commented on your ". $app .".";
		// if ($app === 'photo') {
		// 	$message = $u->full_name . " commented on your photo.";	
		// } else if ($app === 'wallpost') {
		// 	$message = $u->full_name . " commented on your wallpost.";
		// }
		Notifications::create(array(
		'username' => $user,
		'initiator' => $owner,
		'message' => $message,
		'app' => $app,
		'on_id' => $on,
		'path' => $path,
		'date' => $now
		));
	}

	$full_name = $u->full_name;
	$avatar = $u->avatar;
	$now = strtotime($now);
	$comment_id = $new_c->comment_id;
	$response = 
<<<EOF
<li>
	<div class="comment_Avatar">
		<a href="./ $owner ">
			<img src=" $avatar " alt="Avatar">
		</a>
	</div>
	<h6 class="comment_fullName"><a href="./$owner"> $full_name </a></h6>
	<div class="comment_Body">
		<p> $body </p>
	</div>
	<span data-livestamp="$now" class="liveStamp muted"></span>
	<a href="" onclick=" like('comment', '$comment_id', 'like', '$owner'); return false;"><small>Like</small></a>
</li>
EOF;
	echo $response;
	die();
}

?>