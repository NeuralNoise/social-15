<?php 

if (isset($_GET['name']) && isset($_GET['email']) && isset($_GET['pass'])) {
	extract($_GET);
	$success = false;
	$options = array('conditions' => array('username = ? AND email = ? AND password = ?', $name, $email, $pass));
	$user = User::all($options)[0];
	if ($user) {
		$user->activated = '1';
		$user->save();
		$success = true;
	}
	/*
	***********************
	** =View
	***********************
	*/
	$script_b = '
		<script>
		    $(document).ready(function() {
		        $(".modal").modal("toggle");
		        setInterval(function() {
		        location.assign("'.BASE_DIR.'");
		        }, 5000);
		    });
		</script>
	';
	view('views/activation', array(
		'header' => 'header.login.php',
    	'local' => $local,
    	'script_bottom' => $script_b
    	));
}

?>