<?php 

/**
* 
*/
class comment
{
	private $dao,
			$comment,
			$comment_id,
			$body,
			$owner,
			$date,
			$on,
			$app;

	public function __construct() {
		$this->dao = new comment_DAO($this);
	}	

	public function set_from_db($id)
	{
		$this->comment = Comment::find($id);

		$this->comment_id = $id;
		$this->body = $this->comment->body;
		$this->owner = $this->comment->owner;
		$this->date = $this->comment->date;
		$this->on = $this->comment->on_;
		$this->app = $this->comment->app;
	}

	public function set_all($body, $owner, $date, $on, $app) {
		$this->body = $body;
		$this->owner = $owner;
		$this->date = $date;
		$this->on = $on;
		$this->app = $app;
	}

	public function set_body($body) {
		$this->body = $body;
	}
	public function set_owner($owner) {
		$this->owner = $owner;
	}
	public function set_date($date) {
		$this->date = $date;
	}
	public function set_on($on) {
		$this->on = $on;
	}
	public function set_app($app) {
		$this->app = $app;
	}

	public function __get($property) {
		if (property_exists($this, $property) ) {
			return $this->$property;
		} else {
			throw new Exception("Oh nooooo! ... The property: '$property' in the COMMENT CLASS does not exist", 1);
		}
	}
}

?>