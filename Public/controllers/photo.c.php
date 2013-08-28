<?php

try {
	Photos::find($_GET['p_id']);
	User::find($_GET['u']);
} catch (Exception $e) {
	header('Location: ' . BASE_DIR . 'message/no_photo');
}

$p = new photo($_GET['p_id']);

if (strcasecmp($p->owner, $_GET['u']) !== 0) {
	header('Location: ' . BASE_DIR . 'message/no_photo');
}
if (strcasecmp($p->album, $_GET['album']) !== 0 && strcasecmp($_GET['album'] , 'all') !== 0) {
	header('Location: ' . BASE_DIR . 'message/no_photo');
}

$this_user = clone $u;
$my_photo = true;
if (strcasecmp($_GET['u'], $u->username) !== 0) {
	$this_user = new person($_GET['u']);
	$my_photo = false;
}

/*
***********************
** =Comments
***********************
*/
$comments = comment_DAO::fetch_all($p->p_id, 'photo');
$comments_ar = array();
foreach ($comments as $comment) {

	$like_comment = false;
	$options = array('conditions' => array('owner = ? AND app = "comment" AND on_id = ?', $u->username, $comment->comment_id));
	$me_comment_likes = Likes::all($options);
	if ($me_comment_likes) {
		$like_comment = true;
	}
	$options = array('conditions' => array('app = "comment" AND on_id = ?', $comment->comment_id));
	$comment_likes = Likes::all($options);
	$count = count($comment_likes);
	$arr = array(
		'comment_id' => $comment->comment_id,
		'username' => $comment->owner,
		'avatar' => person_DAO::get_avatar($comment->owner),
		'name' => person_DAO::get_full_name($comment->owner),
		'body' => $comment->body,
		'date' => $comment->date,
		'like_comment' => $like_comment,
		'likes_count_comment' => $count,
		'comment_likes' => $comment_likes
		);
	array_push($comments_ar, $arr);
}
/*
***********************
** =Likes
***********************
*/
$options = array('conditions' => array('app = "photo" AND on_id = ?', $p->p_id));
$likes = Likes::all($options);
$likes_count = count($likes);
$like_it = false;

if ($likes) {
	foreach ($likes as $like) {
		if (strcmp($like->owner, $u->username) === 0) {
			$like_it = true;
			break;
		}
	}
}


/*
***********************
** =View
***********************
*/

$script_b = "<script src='js/photo.js'></script>
			<script src='js/jquery.autosize.min.js'></script>
			";
$script_t = '<script>
				function onImgLoad() {
					img = $(".photoView_photo"); 
					h   = img.height(); 
					w   = img.width(); 
					$(".photoView_comments").height(h);
					$("#commentsWrap").height(h - 140);
				}
			</script>
  			 <script src="js/jquery.Jcrop.min.js"></script>
  			 ';
$style = '<link rel="stylesheet" href="css/jquery.Jcrop.min.css">';

$title = 'All Photos';
if (strcasecmp($_GET['album'] , 'all') !== 0) {
	$title = replace_($p->album);
}

$avatar = person_DAO::get_avatar($this_user->username);

view('views/photo', array(
	'p' => $p,
	'this_user' => $this_user,
	'title' => mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'script_bottom' => $script_b,
	'script_top' => $script_t,
	'style' => $style,
	'avatar' => $avatar,
	'comments_ar' => $comments_ar,
	'xView' => $xView,
	'my_photo' => $my_photo,
	'likes' => $likes,
	'likes_count' => $likes_count,
	'like_it' => $like_it
));

?>