<?php 

$message = $_GET['message'];
$m = '';
if ($message === 'not_active') {
        $m = "User profile is not activated. Please check your email for activation code.";             
} else if ($message === 'log_in') {
        $m = 'You need to LogIn first.';
} else if ($message === 'no_user') {
        $m = 'This user does not exist.';
} else if ($message === 'no_photo') {
        $m = 'This photo no longer exists';
}

view('views/message', array(
        'title' => 'Error',
        'message' => $m,
        'xView' => $xView
        ));


?>