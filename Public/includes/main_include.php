<?php 


/*
***********************
** =Notification Check
***********************
*/
$notifications = array('notif_new' => $u->dao->check_notif(), 'notif_top' => $u->dao->all_notif(8));
?>