<?php 

function view($path, $data) {
	extract($data);
	extract($xView);
	$path = $path .'.view.php';
	include "views/layout.php";
}

function transliteration($string) {
    $table = array(
        'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 'д'=>'d',
        'е'=>'e', 'ж'=>'j', 'з'=>'z', 'и'=>'i', 'й'=>'y',
        'к'=>'k', 'л'=>'l', 'м'=>'m', 'н'=>'n', 'о'=>'o',
        'п'=>'p', 'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u',
        'ф'=>'f', 'х'=>'h', 'ц'=>'c', 'ч'=>'ch', 'ш'=>'sh',
        'щ'=>'sht', 'ъ'=>'a', 'ь'=>'y', 'ю'=>'yu', 'я'=>'ya',
        'А'=>'A', 'Б'=>'B', 'В'=>'V', 'Г'=>'G', 'Д'=>'D',
        'Е'=>'E', 'Ж'=>'J', 'З'=>'Z', 'И'=>'I', 'Й'=>'Y',
        'К'=>'K', 'Л'=>'L', 'М'=>'M', 'Н'=>'N', 'О'=>'O',
        'П'=>'P', 'Р'=>'R', 'С'=>'S', 'Т'=>'T', 'У'=>'U',
        'Ф'=>'F', 'Х'=>'H', 'Ц'=>'C', 'Ч'=>'Ch', 'Ш'=>'Sh',
        'Щ'=>'Sht', 'Ъ'=>'A', 'Ь'=>'Y', 'Ю'=>'Yu', 'Я'=>'Ya'
    );
    return strtr($string, $table);
}

function check_user() {
    return 'includes/check_user.php';
}

function parser($file_name) {
    return 'parsers/' . $file_name . '_system.php';
}

function secure($val) {
	if ($val === 'post') {
		$_POST = @array_map('htmlspecialchars', $_POST);
		$_POST = @array_map('addslashes', $_POST);
	} else if ($val === 'get') {
		$_GET = @array_map('htmlspecialchars', $_GET);
		$_GET = @array_map('addslashes', $_GET);
	} else if ($val === 'session') {
        $_SESSION = @array_map('htmlspecialchars', $_SESSION);
        $_SESSION = @array_map('addslashes', $_SESSION);
    } else if ($val === 'cookie') {
        $_COOKIE = @array_map('htmlspecialchars', $_COOKIE);
        $_COOKIE = @array_map('addslashes', $_COOKIE);
    } else {
		throw new Exception("Error Processing Request: Function secure only works with 'post', 'get', 'cookie' and 'session'", 1);		
	}
}

function replace_($haystack) {
    return str_replace('_', ' ', $haystack);
}
function replace_space($haystack) {
    return str_replace(' ', '_', $haystack);
}

// function get_avatar($user, $up = '') {
//     @$avatar = glob($up . "user_data/" . $user . '/avatar/avatar.*')[0];
    
//     return $avatar;
// }

function hash_val($str) {
	return hash('sha256','∅ÏÄ∫' . $str . 'Ω¹ú');
}

function photo_name_generator($ext) {
    return date('Y-m-j-H-i-s') . '_' . rand_str_gen(4) . '.' . $ext;
}

function now() {
    return date('Y-m-j H:i:s');
} 

function logIn($val) {
	
    $name = mb_strtolower($_POST[$val], 'UTF-8');
    $pass = hash_val($_POST['pass']);
    $remember = $_POST['remember'];
    if ($val === 'username') {
    	$user = User::find_by_username($name);
    } else if ($val === 'email') {
    	$user = User::find_by_email($name);
    }

    if ($user === null) {
        echo "<span class='text-error'>Incorrect $val</span>";
        die();
    } else if (strcmp($pass, $user->password) !== 0) {
        echo "<span class='text-error'>Incorrect Password</span>";
        die();
    } else {
        if (!$user->activated) {
            echo 'not_active';
            // Send another activation email
            die();
        }
        
        ////////////////////////////////////////////////////////////
        // Secure cookie value                                    //
        // $cookie_name = hash_val($name);                        //
        // $cookie_separator = hash_val('__');                    //
        // $cookie_val = $cookie_name . $cookie_separator . $pass;//
        ////////////////////////////////////////////////////////////

        $val = $user->username . "//" . $pass;

        $_SESSION['name'] = $user->username;
        $_SESSION['pass'] = $pass;
        $u = new person($user->username);
        $u->dao->update(array(
            'ip' => $_SERVER['REMOTE_ADDR'],
            'last_login' => now(),
            'online' => 1
            ));
        if ($remember === 'true') {
            // Change to SECURE !!!
            setcookie('n', $val, time() + 2592000, "/", "", false, true);
        }
        

        echo 'success';
        die();
    }

}

function controller( $name )  
{  
    return ('controllers/' . $name . '.c' . '.php' );  
}

function main_inc() {
    return 'includes/main_include.php';
}

function rand_str_gen($len) {
    $result = "";
    $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
        $randItem = array_rand($charArray);
        $result .= "".$charArray[$randItem];
    }
    return $result;
}
?>