<?php 

/**
* 
*/
class notification_DAO
{
	private $notif,
			$notif_id,
			$username,
			$initiator,
			$app,
			$on_id,
			$did_read,
			$date;

	function __construct($id)
	{
		$this->notif = Notifications::find($id);

		$this->notif_id = $this->notif->notif_id;
		$this->username = $this->notif->username;
		$this->initiator = $this->notif->initiator;
		$this->app = $this->notif->app;
		$this->on_id = $this->notif->on_id;
		$this->did_read = $this->notif->did_read;
		$this->date = $this->notif->date;
	}

	
}

?>