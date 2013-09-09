<?php 

/**
* 
*/
class comment_DAO
{
	private $c;

	public function __construct($obj) {
		 if (is_object($obj)) {
		 	$this->c = $obj;
		 } else {
		 	throw new Exception('DAO constructor requires an object as a parameter', 1);	
		 }		
	}

	public function create() {
		return Comments::create(array(
			'body' => $this->body,
			'owner' => $this->owner,
			'date' => $this->date,
			'on_' => $this->on,
			'app' => $this->app
			));
	}

	public function remove() {
		$this->comment->delete();
	}

	public function commenters() {
		$options = array('conditions' => array('on_ = ? AND app = ?', $this->on, $this->app), 'group' => 'owner');
		return Comments::all($options);
	}

	public static function fetch_all($on, $app) {
		$options = array('conditions' => array('on_ = ? AND app = ?', $on, $app), 'order' => 'date desc');
		return Comments::all($options);
	}
	public static function prepare_for_view(array $comments, person $u) {
		$return = array();
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
			array_push($return, $arr);
		}
		return $return;
	}

	public function __get($property) {
		if (property_exists($this->c, $property) ) {
			return $this->c->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the COMMENT_DAO CLASS does not exist", 1);
		}
	}
}

?>