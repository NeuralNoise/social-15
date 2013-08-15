<?php 


if (isset($_POST['first_name']) ) {
	extract($_POST);
	unset($_POST['ajax']);
	unset($_POST['parser']);

	$update = array();
	foreach ($_POST as $key => $value) {
		if (!empty($value) ) {
			$update[$key] = $value;
		}
	}
	if (!empty($update) ) {
		$u->dao->update($update);
		echo 'success';die();
	}
}

?>