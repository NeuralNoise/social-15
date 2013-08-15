<?php 


$all_notifications = $u->dao->all_notif();
/*
***********************
** =View
***********************
*/
$script_b = '
<script>
	(function($){
	    $(window).load(function(){
	        $(".allNotifications_wrap").mCustomScrollbar({
	        	theme:"dark-thick",
	        	autoHideScrollbar: true
	        });
	    });
	})(jQuery);
</script>
';
view('views/notifications', array(
	'notifications' => $notifications,
	'u' => $u,
	'all_notifications' => $all_notifications,
	'title' => 'Notifications',
	'script_bottom' => $script_b,
	'local' => $local
	));

?>