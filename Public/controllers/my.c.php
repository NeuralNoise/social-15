<?php 


/*
***********************
** =View
***********************
*/
$style = '<link rel="stylesheet" href="css/jquery.Jcrop.min.css">';

$script = "<script src='js/my.js'></script>
           <script src='js/jquery.Jcrop.min.js'></script>
           ";
$title = $u->username;
if ($u->first_name !== null && $u->last_name !== null ) {
	$title =  $u->full_name;
}
$avatar = person_DAO::get_avatar($u->username);

view('views/my', array(
	'title'=>mb_convert_case($title, MB_CASE_TITLE, "UTF-8"),
	'u'=> $u,
	'script_bottom' => $script,
	'avatar' => $avatar,
	'style' => $style,
	'notifications' => $notifications,
	'local' => $local
	));

?>