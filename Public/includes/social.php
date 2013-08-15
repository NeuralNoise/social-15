<?php 
date_default_timezone_set('EET');


	if (file_exists('../../cfg/config.php') ) {
		require_once '../../cfg/config.php';
	} else {
		require_once '../config.php';
	}


require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'models/person.class.php';
require_once 'models/photo.class.php';
require_once 'models/comment.class.php';
require_once 'models/notification.class.php';
require_once 'dao/person_dao.class.php';
require_once 'dao/photo_dao.class.php';
require_once 'dao/comment_dao.class.php';
require_once 'dao/notification_dao.class.php';

?>