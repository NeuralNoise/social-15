<?php 

$this_user = User::find_by_username($_GET['user']);
if ($this_user === null) {
	header('Location: ' . BASE_DIR . 'message/no_user');
}

$this_user = new person($_GET['user']);

/*
***********************
** =Add/Remove/Block 
***********************
*/
$cond = array('conditions' => array("blocker= ? AND blockee= ?", $this_user->username, $u->username) );
$blocked_me = Blockedusers::all($cond);

$cond = array('conditions' => array("blocker= ? AND blockee= ?",$u->username, $this_user->username) );
$blocked_this_user = Blockedusers::all($cond);

$cond = array('conditions' => array('user1 = ? AND user2 = ? AND accepted="1" OR user1 = ? AND user2 = ? AND accepted="1"', $u->username, $this_user->username, $this_user->username, $u->username) );
$friends = Friends::all($cond);

$cond = array('conditions' => array('user1 = ? AND user2 = ? AND accepted="0"', $u->username, $this_user->username) );
$pending = Friends::all($cond);

$cond = array('conditions' => array('user2 = ? AND user1 = ? AND accepted="0"', $u->username, $this_user->username) );
$waiting = Friends::all($cond);

/*
***********************
** =Wallposts
***********************
*/
if (empty($_GET['post']) && empty($_GET['about']) ) {
	$options = array('conditions' => array('on_user = ?', $this_user->username), 'order' => 'date desc');
	$w = Wallposts::all($options);
	$wallposts = [];
	foreach ($w as $wallpost) {
		// comments
		$options = array('conditions' => array('on_ = ? AND app = "wallpost"', $wallpost->w_id));
		$comments_count_int = Comments::count($options);
		$comments_count = '';
		if ($comments_count_int) {
			$comments_count = ' (' . $comments_count_int . ')';
		} else {
			$comments_count = '';
		}
		$options = array('conditions' => array('on_ = ? AND app = "wallpost" ', $wallpost->w_id), 'order' => 'date desc', 'limit' => 5);
		$comments = Comments::all($options);
		$comments_ar = comment_DAO::prepare_for_view($comments, $u);

		// likes
		$options = array('conditions' => array('app = "wallpost" AND on_id = ?', $wallpost->w_id));
		$likes = Likes::all($options);
		$likes_count = count($likes);
		$like_it = false;
		if ($likes) { 
			if (Likes::all(array('conditions' => array('owner = ? AND on_id = ? AND app = "wallpost"', $u->username, $wallpost->w_id)))) {
				$like_it = true;
			}
		}
		
		$avatar = person_DAO::get_avatar($wallpost->from_user);
		$full_name = person_DAO::get_full_name($wallpost->from_user);
		$arr = array(
			'full_name' => $full_name,
			'username' => $wallpost->from_user,
			'avatar' => $avatar,
			'body' => $wallpost->body,
			'date' => $wallpost->date,
			'comments_count' => $comments_count,
			'comments_count_int' => $comments_count_int,
			'likes' => $likes,
			'likes_count' => $likes_count,
			'like_it' => $like_it,
			'w_id' => $wallpost->w_id,
			'comments_ar' => $comments_ar
			);
		array_push($wallposts, $arr);
	}	
}


/*
***********************
** =Single Post View
***********************
*/
$post = false;
$wallpost = array();
if (isset($_GET['post']) ) {
	$post = true;
	$wallpost = Wallposts::find($_GET['post']);
	
	$options = array('conditions' => array('on_ = ? AND app = "wallpost" ', $wallpost->w_id), 'order' => 'date desc');
	$comments = Comments::all($options);
	$comments_ar = comment_DAO::prepare_for_view($comments, $u);

	// likes
	$options = array('conditions' => array('app = "wallpost" AND on_id = ?', $wallpost->w_id));
	$likes = Likes::all($options);
	$likes_count = count($likes);
	$like_it = false;
	if ($likes) { 
		if (Likes::all(array('conditions' => array('owner = ? AND on_id = ? AND app = "wallpost"', $u->username, $wallpost->w_id)))) {
			$like_it = true;
		}
	}
	
	$avatar = person_DAO::get_avatar($wallpost->from_user);
	$full_name = person_DAO::get_full_name($wallpost->from_user);
	$wallpost = array(
		'full_name' => $full_name,
		'username' => $wallpost->from_user,
		'avatar' => $avatar,
		'body' => $wallpost->body,
		'date' => $wallpost->date,
		'likes' => $likes,
		'likes_count' => $likes_count,
		'like_it' => $like_it,
		'w_id' => $wallpost->w_id,
		'comments_ar' => $comments_ar
		);
}

/*
***********************
** =View
***********************
*/
$about = false;
if (isset($_GET['about']) ) {
	$about = true;
}
$title = $this_user->username;
if ($this_user->first_name !== null && $this_user->last_name !== null ) {
	$title =  $this_user->full_name;
}

$birthday = date('F j, Y', strtotime($this_user->birth_date));

$avatar = person_DAO::get_avatar($this_user->username);

$script = "<script src='js/user.js'></script> <script src='js/jquery.autosize.min.js'></script>";
if (!empty($blocked_me)) {
	view("views/user_blocked", array(
	'this_user' => $this_user,
	'title' => mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'xView' => $xView
	));
} else if ($about && !empty($friends)) {
	view('views/about', array(
	'xView' => $xView,
	'title' => $title,
	'this_user' => $this_user,
	'avatar' => $avatar,
	'birthday' => $birthday
	));
} else if ($post && !empty($friends)) {
	view('views/wallpost', array(
	'xView' => $xView,
	'title' => $title,
	'this_user' => $this_user,
	'wallpost' => $wallpost,
	'this_user' => $this_user
	));
} else if (!empty($friends) ) {
	view("views/user_friends", array(
	'this_user' => $this_user,
	'title' => mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'avatar' => $avatar,
	'script_bottom' => $script,
	'xView' => $xView,
	'wallposts' => $wallposts
	));
} else {
	view("views/user", array(
	'this_user' => $this_user,
	'title' => mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'script_bottom' => $script,
	'pending' => $pending,
	'waiting' => $waiting,
	'blocked_this_user' => $blocked_this_user,
	'avatar' => $avatar,
	'xView' => $xView
	));
}


?>