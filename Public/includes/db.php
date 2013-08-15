<?php 

require 'dependencies/php-activerecord/ActiveRecord.php';

$cfg = ActiveRecord\Config::instance();
$cfg->set_model_directory('models/ActiveRecordModels');
$cfg->set_connections(array(
	'development' => 'mysql://'. $db_username . ':' . $db_password . '@' . $db_host . '/' . $db_database . ';charset=utf8'));

?>