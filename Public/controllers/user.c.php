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
** =View
***********************
*/
$title = $this_user->username;
if ($this_user->first_name !== null && $this_user->last_name !== null ) {
	$title =  $this_user->full_name;
}

$avatar = person_DAO::get_avatar($this_user->username);

$script = "<script src='js/user.js'></script>";
if (!empty($blocked_me)) {
	view("views/user_blocked", array(
	'this_user' => $this_user,
	'title' => mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'xView' => $xView
	));
} else if (!empty($friends) ) {
	view("views/user_friends", array(
	'this_user' => $this_user,
	'title' => mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'avatar' => $avatar,
	'script_bottom' => $script,
	'xView' => $xView
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