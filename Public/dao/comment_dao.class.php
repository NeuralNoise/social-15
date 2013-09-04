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

	public function __get($property) {
		if (property_exists($this->c, $property) ) {
			return $this->c->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the COMMENT_DAO CLASS does not exist", 1);
		}
	}
}

?>