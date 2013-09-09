<?php 

use PHPImageWorkshop\ImageWorkshop;

require_once 'dependencies/phpimageworkshop/ImageWorkshop.php';

/*
***********************
** =Upload
***********************
*/
if (isset($_FILES['img']) ) {
	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
	$album = replace_space(trim($_REQUEST['album']));
	$response = array();
	foreach ($_FILES["img"]["error"] as $key => $error) {
		
		if ($error > 0) {
			echo "Error: " . $error; die();
		} else {
			$name = $_FILES['img']['name'][$key];
			$tmp  = $_FILES["img"]["tmp_name"][$key];
			$ext  = pathinfo($name, PATHINFO_EXTENSION);
			$size = $_FILES['img']['size'][$key];
			if (!in_array($ext, $allowedExts) ) {
				echo 'File must be gif, jpg, jpeg or png';
				die();
			}
			list($width, $height) = getimagesize($tmp);
			if ($width < 350 || $height < 350) {
				echo "The image has no dimensions";
				die();		
			}		
			if ($size > 5242880 * 8) {
				echo 'Max File Size is 40 megabytes';
				die();
			}

			if (!file_exists("user_data/" . $u->username . "/photos/". $album) ) {
				mkdir("user_data/" . $u->username . "/photos/". $album, 0755);
			}

			$new_name = photo_name_generator($ext);
			$path = "user_data/" . $u->username . '/photos/'. $album .'/'. $new_name;
			if (move_uploaded_file($tmp, $path) ) {
				$layer = ImageWorkshop::initFromPath($path);
				$newLargestSideWidth = 960; // px
				$conserveProportion = true; 
				$layer->resizeByLargestSideInPixel($newLargestSideWidth, $conserveProportion);

				$l_dirPath = "user_data/" . $u->username . '/photos/'. $album;
				$l_filename = $new_name;
				$l_createFolders = true;
				$l_backgroundColor = null;
				$l_imageQuality = 95;
				$layer->save($l_dirPath, $l_filename, $l_createFolders, $l_backgroundColor, $l_imageQuality);				
				$new_photo = Photos::create(array(
							'owner' => $u->username,
							'album' => $album,
							'path' => $path,
							'upload_date' => now()
							));

				array_push($response, array('p_id' => $new_photo->p_id, 'path' => $new_photo->path));
			}
		}
	}
	echo 'success';
	echo json_encode($response); die();
}


// Avatar
if (isset($_FILES['avatar']) ) {
	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");

	if ($_FILES["avatar"]["error"] > 0) {
	  echo "Error: " . $_FILES["avatar"]["error"]; die();
	} else {
		$name = $_FILES['avatar']['name'];
		$tmp  = $_FILES["avatar"]["tmp_name"];
		$ext  = pathinfo($name, PATHINFO_EXTENSION);
		$size = $_FILES['avatar']['size'];
		if (!in_array($ext, $allowedExts) ) {
			echo 'File must be gif, jpg, jpeg or png';
			die();
		}
		list($width, $height) = getimagesize($tmp);
		if ($width < 350 || $height < 350) {
			echo "The image has no dimensions";
			die();		
		}		
		if ($size > 5242880 * 8) {
			echo 'Max File Size is 40 megabytes';
			die();
		}
		if ($user_ok) {
			if (!file_exists("user_data/" . $u->username . "/photos/Profile_pictures/") ) {
				mkdir("user_data/" . $u->username . "/photos/Profile_pictures/", 0755);
			}
			

			$new_name = photo_name_generator($ext);
			$path = "user_data/" . $u->username . '/photos/Profile_pictures/' . $new_name;
			if (move_uploaded_file($tmp, $path) ) {
				$layer = ImageWorkshop::initFromPath($path);
				$layer_tmp = clone $layer;

				$newLargestSideWidth = 960; // px
				$conserveProportion = true; 
				$layer->resizeByLargestSideInPixel($newLargestSideWidth, $conserveProportion);

				$newLargestSideWidth_tmp = 600; // px
				$conserveProportion_tmp = true; 
				$layer_tmp->resizeByLargestSideInPixel($newLargestSideWidth_tmp, $conserveProportion_tmp);

				$l_dirPath = "user_data/" . $u->username . '/photos/Profile_pictures/';
				$l_filename = $new_name;
				$l_createFolders = true;
				$l_backgroundColor = null;
				$l_imageQuality = 95;
				$layer->save($l_dirPath, $l_filename, $l_createFolders, $l_backgroundColor, $l_imageQuality);				
				$new_photo = Photos::create(array(
					'owner' => $u->username,
					'album' => 'profile_pictures',
					'path' => "user_data/" . $u->username . "/photos/Profile_pictures/" . $new_name,
					'upload_date' => now()
					));
				$u->dao->update(array('avatar_id' => $new_photo->id));
				$tmp_name = 'tmp.' . $ext;
				$tmp_dirPath = "user_data/" . $u->username . '/avatar/';
				$tmp_filename = $tmp_name;
				$tmp_createFolders = true;
				$tmp_backgroundColor = null;
				$tmp_imageQuality = 95;

				$tmp = glob($tmp_dirPath . 'tmp*');
				foreach ($tmp as $tmp) {		
					unlink($tmp);		
				}

				$layer_tmp->save($tmp_dirPath, $tmp_filename, $tmp_createFolders, $tmp_backgroundColor, $tmp_imageQuality);				

				echo "user_data/" . $u->username . '/avatar/' . $tmp_name;
				die();
		} else {
			echo "error"; die();
		}
		}
		
	}
}

/*
***********************
** =Crop with coordinates
***********************
*/

if (isset($_POST['crop']) && $_POST['crop'] === '1') {
	$path = $_POST['path'];
	list($width, $height) = getimagesize($path);
	$w = $_POST['w'];
	$h = $_POST['h'];
	$x = $_POST['x'];
	$y = $_POST['y'];
	$y = $height - ($y + $h);
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$layer = ImageWorkshop::initFromPath($path);
	$layer->cropInPixel($w, $h, $x, $y, 'LB');
	$l_dirPath = "user_data/" . $u->username . '/avatar/';
	$l_filename = 'avatar.' . $ext;
	$l_createFolders = true;
	$l_backgroundColor = null;
	$l_imageQuality = 95;
	$avatars = glob($l_dirPath . 'avatar.*');
	foreach ($avatars as $avatar) {		
		unlink($avatar);		
	}

	$layer->save($l_dirPath, $l_filename, $l_createFolders, $l_backgroundColor, $l_imageQuality);
	echo 'success';die();
}

/*
***********************
** =Crop with resize
***********************
*/

if (isset($_POST['crop']) && $_POST['crop'] === '0') {
	$path = $_POST['path'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);
	$layer = ImageWorkshop::initFromPath($path);

	$newLargestSideWidth = 350; // px
	$conserveProportion = true;
	$layer->resizeByLargestSideInPixel($newLargestSideWidth, $conserveProportion);

	$l_dirPath = "user_data/" . $u->username . '/avatar/';
	$l_filename = 'avatar.' . $ext;
	$l_createFolders = true;
	$l_backgroundColor = null;
	$l_imageQuality = 95;

	$avatars = glob($l_dirPath . 'avatar.*');
	foreach ($avatars as $avatar) {		
		unlink($avatar);		
	}

	$layer->save($l_dirPath, $l_filename, $l_createFolders, $l_backgroundColor, $l_imageQuality);

	echo 'success';die();
}

/*
***********************
** =Edit
***********************
*/

if (isset($_POST['editThumb']) ) {
	$tmp = glob("user_data/" . $u->username . '/avatar/t*.*');
	echo $tmp[0];die();
	die();
}

/*
***********************
** =Delete
***********************
*/

if (isset($_POST['deletePhoto']) ) {
	$id = $_POST['p_id'];
	$photo = Photos::find($id);
	$path = $photo->path;
	try {
		$photo->delete();
	} catch (Exception $e) {
		echo 'problem';
		die();
	}

	$options = array('conditions' => array('avatar_id = ?', $id));
	$user = Useroptions::all($options);
	if ($user) {
		$user = $user[0];
		$user->avatar_id = null;
		$user->save();
		$avatar = person_DAO::get_avatar($user->username);
		if ($avatar !== 'img/default_avatar.jpg') {
			unlink($avatar);
		}
	}

	unlink($path);
	echo 'success';
	die();
}

/*
***********************
** =Make Profile Pic
***********************
*/

if (isset($_POST['makeProfile']) ) {
	$id = $_POST['p_id'];
	$p = Photos::find($id);
	$user = Useroptions::find($p->owner);
	$ext  = pathinfo($p->path, PATHINFO_EXTENSION);
	$layer = ImageWorkshop::initFromPath($p->path);
	$newLargestSideWidth = 600; // px
	$conserveProportion = true;
	$layer->resizeByLargestSideInPixel($newLargestSideWidth, $conserveProportion);

	$tmp_dirPath = "user_data/" . $user->username . '/avatar/';
	$tmp_filename = 'tmp.' . $ext;;
	$tmp_createFolders = true;
	$tmp_backgroundColor = null;
	$tmp_imageQuality = 95;
	$tmp = glob($tmp_dirPath . 'tmp*');
	foreach ($tmp as $tmp) {	
		unlink($tmp);		
	}
	$layer->save($tmp_dirPath, $tmp_filename, $tmp_createFolders, $tmp_backgroundColor, $tmp_imageQuality);
	$user->avatar_id = $id;
	$user->save();
	if (strcasecmp($p->album, 'profile_pictures') !== 0) {
		$new_name = photo_name_generator($ext);
		$new_photo = Photos::create(array(
			'owner' => $user->username,
			'album' => 'profile_pictures',
			'path' => "user_data/" . $user->username . "/photos/Profile_pictures/" . $new_name,
			'upload_date' => now()
			));
		if (!copy($p->path, $new_photo->path)) {
			echo 'error';die();
		}
	}
	echo "user_data/" . $user->username . '/avatar/' . $tmp_filename;
	die();

}


/*
***********************
** =Descriptions
***********************
*/
if (isset($_POST['addDescription']) ) {
	if (isset($_POST['many']) ) {
		$data = $_POST['data'];
		$arr = explode('///', $data);
		array_pop($arr);

		foreach ($arr as $str) {
			$a = explode('/:/', $str);
			$p = Photos::find($a[0]);
			$p->description = $a[1];
			$p->save();
		}
		echo 'success';die;

	} else {
		$p_id = $_POST['p_id'];
		$desc = $_POST['desc'];
		if (empty($desc) ) {
			$desc = null;
		}
		$p = Photos::find($p_id);
		$p->description = $desc;
		$p->save();
		echo 'success';die;
	}	
}

/*
***********************
** =Remove Album
***********************
*/
if (isset($_POST['removeAlbum']) ) {
		extract($_POST);
		if ($album !== 'profile_pictures') {
			$options = array('conditions' => array('owner = ? AND album = ?', $user, $album));
			$photos = Photos::all($options);
			foreach ($photos as $photo) {
				unlink($photo->path);
				$photo->delete();
			}
		
			rmdir('user_data/' . $user . '/photos/' . $album);
			echo 'success';die;
		}
		
}

?>