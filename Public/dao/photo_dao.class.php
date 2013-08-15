<?php 

/**
* 
*/
class photo_DAO
{
	private $p;

	public function __construct($obj)
	{
		if (is_object($obj)) {
		 	$this->p = $obj;
		 } else {
		 	throw new Exception('DAO constructor requires an object as a parameter', 1);
		 }
	}

	public function fetch_album() {
		$options = array('conditions' => array('owner = ? AND album = ?', $this->owner, $this->album), 'order' => 'p_id');
		$photos_obj = Photos::all($options);
		$photos = array();
		foreach ($photos_obj as $photo) {
			$photos[$photo->p_id] = $photo;
		}
		return $photos;
	}

	public function next($curr, $all) {
		if (strcasecmp($all, 'all') !== 0) {
			$options = array('conditions' => array('owner = ? AND album = ? AND p_id > ?', $this->owner, $this->album, $curr), 'order' => 'p_id', 'limit' => 1);
			$return = Photos::all($options);
			if (empty($return) ) {
				return current($this->fetch_album());
			}
			return $return[0];
		} else {
			$options = array('conditions' => array('owner = ? AND p_id > ?', $this->owner, $curr), 'order' => 'p_id', 'limit' => 1);
			$return = Photos::all($options);
			if (empty($return) ) {
				$return = self::all_photos($this->owner);
				return end($return);
			}
			return $return[0];
		}
		
	}

	public function previous($curr, $all) {
		if (strcasecmp($all, 'all') !== 0) {
			$options = array('conditions' => array('owner = ? AND album = ? AND p_id < ?', $this->owner, $this->album, $curr), 'order' => 'p_id desc', 'limit' => 1);
			$return = Photos::all($options);
			if (empty($return) ) {
				$return = $this->fetch_album();
				return end($return);
			}
			return $return[0];
		} else {
			$options = array('conditions' => array('owner = ? AND p_id < ?', $this->owner, $curr), 'order' => 'p_id desc', 'limit' => 1);
			$return = Photos::all($options);
			if (empty($return) ) {
				$return = self::all_photos($this->owner);
				return current($return);
			}
			return $return[0];
		}
	}

	public static function all_photos($username) {
		// SELECT * FROM photos WHERE owner = $username ORDER BY p_id DESC;
		$options = array('conditions' => array('owner = ?', $username), 'order' => 'p_id desc');
		return Photos::all($options);
		// $return = [];
		// foreach ($photos_obj as $photo) {
		// 	array_push($return, $photo->path);
		// }
		// return $return;
	}

	public static function albums($username) {
		// SELECT * FROM photos WHERE owner = $this->username ORDER BY album GROUP BY album;
		$options = array('conditions' => array('owner = ?', $username), 'order' => 'album', 'group' => 'album');
		$albums = Photos::all($options);
		$return = [];
		foreach ($albums as $album) {
			array_push($return, $album->album);
		}
		return $return;
	}

	public function __get($property) {
		if (property_exists($this->p, $property) ) {
			return $this->p->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the PHOTO CLASS does not exist", 1);
		}
	}
}

?>