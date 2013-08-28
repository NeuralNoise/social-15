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
				'message' => person_DAO::get_full_name($owner) . " commented on a photo.",
				'app' => 'photo',
				'on_id' => $on,
				'path' => $path,
				'date' => $now
				));
		}
	}
	if (strcmp($owner, $user) !== 0 ) {
		$message = '';
		if ($app === 'photo') {
			$message = person_DAO::get_full_name($owner) . " commented on your photo.";	
		}		
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

	$full_name = person_DAO::get_full_name($owner);
	$avatar = person_DAO::get_avatar($owner);
	$avatar = strstr($avatar, 'u');
	$now = strtotime($now);
	$response = 
<<<EOF
<li>
	<div class="photoComment_Avatar">
		<a href="./ $owner ">
			<img src=" $avatar " alt="Avatar">
		</a>
	</div>
	<h6 class="photoComment_fullName"><a href="./$owner"> $full_name </a></h6>
	<div class="photoComment_Body">
		<p> $body </p>
	</div>
	<span data-livestamp="$now" class="liveStamp muted"></span>
</li>
EOF;
	echo $response;
	die();
}

?>