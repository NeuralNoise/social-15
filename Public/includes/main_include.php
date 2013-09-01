<?php 

/*
***********************
** =First and last name check
***********************
*/
$has_name = true;
if (isset($u) ) {
    if ($u->first_name == '' || $u->last_name == '') {
        $has_name = false;
    }
}

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
$my_avatar = person_DAO::get_avatar($u->username);

$xView = array('notifications' => $notifications, 'local' => $local, 'u' => $u, 'has_name' => $has_name, 'my_avatar' => $my_avatar);
?>