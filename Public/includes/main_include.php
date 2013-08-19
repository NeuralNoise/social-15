<?php 


/*
***********************
** =Notification Check
***********************
*/
$notifications = array('notif_new' => $u->dao->check_notif(), 'notif_top' => $u->dao->all_notif(8));


/*
***********************
** =All Views Data
***********************
*/
$xView = array('notifications' => $notifications, 'local' => $local, 'u' => $u);
?>