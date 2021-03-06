<?php 

function view($path, $data) {
	extract($data);
    if (isset($xView)) {
        extract($xView);   
    }
	$path = $path .'.view.php';
	include "views/layout.php";
}

function dd($var) { // dump & die
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die;
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

function wild_card($str) {
    return '%' . $str . '%';
}

function check_user() {
    return 'includes/check_user.php';
}

function parser($file_name) {
    return 'parsers/' . $file_name . '_system.php';
}

function sanitize($text) {
    $text = htmlspecialchars($text, ENT_QUOTES);
    $text = str_replace("\n\r","\n",$text);
    $text = str_replace("\r\n","\n",$text);
    $text = str_replace("\n","<br>",$text);
    $text = str_replace("&lt;a","<a",$text);
    $text = str_replace("href=&#039;","href='",$text);
    $text = str_replace("&#039;&gt;http://","'>http://",$text);
    $text = str_replace("&#039;&gt;https://","'>https://",$text);
    $text = str_replace("&#039;&gt;ftp://","'>ftp://",$text);
    $text = str_replace("&#039;&gt;file://","'>file://",$text);
    $text = str_replace("&lt;/a&gt;","</a>",$text);
    $text = str_replace("&#039; target=&#039;_blank'","' target='_blank'",$text);
    return $text;
}

function secure($val) {
	if ($val === 'post') {
		$_POST = @array_map('sanitize', $_POST);
		$_POST = @array_map('mysql_real_escape_string', $_POST);
	} else if ($val === 'get') {
		$_GET = @array_map('sanitize', $_GET);
		$_GET = @array_map('mysql_real_escape_string', $_GET);
	} else if ($val === 'session') {
        $_SESSION = @array_map('sanitize', $_SESSION);
        $_SESSION = @array_map('mysql_real_escape_string', $_SESSION);
    } else if ($val === 'cookie') {
        $_COOKIE = @array_map('sanitize', $_COOKIE);
        $_COOKIE = @array_map('mysql_real_escape_string', $_COOKIE);
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