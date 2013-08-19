<?php 

/**
* Person data access object
*/
class person_DAO
{	
	private $u;
	
	public function __construct($obj) {
		 if (is_object($obj)) {
		 	$this->u = $obj;
		 } else {
		 	throw new Exception('DAO constructor requires an object as a parameter', 1);	
		 }		
	}

	public function friends() {
		// SELECT * FROM friends WHERE user1 = $this->username AND accepted = 1 OR user2 = $this->username AND accepted = 1;
		$cond = array('conditions' => array('user1 = ? AND accepted = "1" OR user2 = ? AND accepted="1"', $this->username, $this->username) );
		$friends = Friends::all($cond);
		$all = array();

		foreach ($friends as $fr) {
			if (strcmp($fr->user1, $this->username) === 0) {
				array_push($all, $fr->user2);
			} else if (strcmp($fr->user2, $this->username) === 0 ) {
				array_push($all, $fr->user1);
			}
		}

		sort($all, SORT_STRING);
		// $friends = array();
		// foreach ($all as $name) {
		// 	$fr = User::find_by_username($name);
		// 	array_push($friends, $fr);
		// }

		return $all;

	}

	public function friend_count() {
		$i = 0;
		foreach ($this->friends() as $fr) {
			$i++;
		}
		return $i;
	}

	public function update($vals) {
		// Vals = ['column' => value];
		$users_cols = array('username', 'email', 'password', 'online', 'last_login', 'notif_check', 'actvated', 'ip', 'permission');
		if (is_array($vals)) {
			foreach ($vals as $col => $val) {
				if (in_array($col, $users_cols) ) {
					$this->user->$col = $val;
					$this->user->save();
				} else {
					$this->useroptions->$col = $val;
					$this->useroptions->save();
				}
			}		
		} else {
			throw new Exception("Error: Update method requires an array as an argument", 1);
			
		}
	}

	public function check_notif() {
		$options = array('conditions' => array('username = ? AND date > ?', $this->username, $this->notif_check) );
		return Notifications::all($options);
	}

	public function all_notif($limit = '') {
		$options = array('conditions' => array('username = ?', $this->username), 'order' => 'date desc', 'limit' => $limit);
		return Notifications::all($options);
	}

	public function notif_checked() {
		$this->update(array('notif_check' => now() ));
	}

	public static function get_avatar_full($username) {
		$user = Useroptions::find($username);
		if (empty($user->avatar_id) ) {
			return 'img/default_avatar.jpg';
		}
		return Photos::find($user->avatar_id)->path;
	}

	public static function get_avatar($user) {
	    @$avatar = glob("user_data/" . $user . '/avatar/avatar.*')[0];
	    if (empty($avatar) ) {
	    	return 'img/default_avatar.jpg';
	    }
	    return $avatar;
	}

	public static function get_full_name($username) {
		$user = Useroptions::find($username);
		if ($user->first_name == '' || $user->last_name == '') {
			return $user->username;
		}
		return mb_convert_case($user->first_name . ' ' . $user->last_name, MB_CASE_TITLE, "UTF-8");
	}

	public function __get($property) {
		if (property_exists($this->u, $property) ) {
			return $this->u->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the PERSON_DAO CLASS does not exist", 1);
		}
	}

}

?>