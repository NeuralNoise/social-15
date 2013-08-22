<?php 

if (isset($_POST['method']) && $_POST['method'] == 'normal') {
	$str = $_POST['str'];
	if (empty($str) ) {
		die;
	}
	$results = array();

	if (strpos($str, ' ') ) {
		$words = explode(' ', $str);
		$strs = array();
		foreach ($words as $word) {
			array_push($strs, wild_card($word));
		}
		$users = array();
		foreach ($strs as $str) {
			$options = array('conditions' => array('username LIKE ? || first_name LIKE ? || last_name LIKE ?', $str, $str, $str));
			$user = Useroptions::all($options);
			if (!empty($user) ) {
				array_push($users, $user[0]);	
			}
			
		}
		$users = array_unique($users);
		foreach ($users as $user) {
			$username = $user->username;
			$json = array('username' => $username, 'full_name' => person_DAO::get_full_name($username), 'avatar' => person_DAO::get_avatar($username));
			array_push($results, $json);
		}
		if (!empty($results) ) {
			echo json_encode($results);die;	
		} else {
			die;
		}
		
		
	} else {
		$str = wild_card($str);
		$options = array('conditions' => array('username LIKE ? || first_name LIKE ? || last_name LIKE ?', $str, $str, $str));
		$users = Useroptions::all($options);
		foreach ($users as $user) {
			$username = $user->username;
			$json = array('username' => $username, 'full_name' => person_DAO::get_full_name($username), 'avatar' => person_DAO::get_avatar($username));
			array_push($results, $json);
		}
		if (!empty($results) ) {
			echo json_encode($results);die;	
		} else {
			die;
		}
	}	
}

?>