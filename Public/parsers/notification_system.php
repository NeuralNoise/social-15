<?php 

if (isset($_POST['checked']) ) {
	$u->dao->notif_checked();
	die();
}

if (isset($_POST['check']) ) {
	$notifications = $u->dao->check_notif();
	$response = array();

	if (empty($notifications) ) {
		echo 'empty';
		die();
	} else {
		foreach ($notifications as $notif) {
			$href = $notif->path;
			$message = $notif->message;
			$date = strtotime($notif->date);
			array_push($response, ['href' => $href, 'message' => $message, 'time' => $date, 'append' => "<li><a href='{$href}'>{$message}<br><span data-livestamp='{$date}' data-time='{$date}'></span></a></li>"]);
			// $response = ['href' => $notif->path, 'message' => $notif->message];
		}
		echo json_encode($response);
		die();
	}
}
?>