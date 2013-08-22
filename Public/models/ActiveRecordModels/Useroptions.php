<?php 

class Useroptions extends ActiveRecord\Model {

	
	
	public function __toString() {
        return $this->username;
    }
}

?>