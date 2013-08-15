<?php 

/*
***********************
** =Reg
***********************
*/

if (isset($_POST['usernamecheck']) ) {
    secure('post');
    $name = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);

    if (strlen($name) < 3 || strlen($name) > 16) {
        echo "3 - 16 characters please";
        die();
    }

    if (is_numeric($name[0])) {
        echo "Usernames must begin with a letter";
        die();
    }

    $result = User::find_by_username($name);
    if ($result === null) {
        echo "<img src='img/tick.png'>";
        die();
    } else {
        echo "$name is taken";
        die();
    }
}

if (isset($_POST['emailcheck']) ) {
    secure('post');
    $email = preg_replace('#[\' " ,]#', '', $_POST['emailcheck']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        echo "$email is not a valid email address";
        die();
    }

    $result = User::find_by_email($email);
    if ($result === null) {
        echo "<img src='img/tick.png'>";
        die();
    } else {
        echo "$email is taken";
        die();
    }

}

if (isset($_POST['u']) ) {
    secure('post');
    $name = mb_strtolower(preg_replace('#[^a-z0-9]#i', '', $_POST['u']), 'UTF-8');
    $pass = hash_val($_POST['p']);
    $email = mb_strtolower(preg_replace('#[\' " ,]#', '', $_POST['e']), 'UTF-8');
    $country = $_POST['c'];
    $gender = $_POST['g'];
    $birth_date = $_POST['d'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $now = now();
    $result = User::find_by_username($name);
    $e = User::find_by_email($email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
        echo "$email is not a valid email address.";
        die();
    } else if ($e !== null) {
        echo "$email is already taken.";
        die();
    } else if ($result !== null) {
        echo "$name is already taken.";
        die();
    } else if (strlen($name) < 3 || strlen($name) > 16) {
        echo " Username must be 3 - 16 characters.";
        die();
    } else if (is_numeric($name[0])) {
        echo "Usernames must begin with a letter";
        die();
    } else if($name == "" || $email == "" || $pass == "" || $gender == "" || $country == "" || stristr($birth_date, 'd') || stristr($birth_date, 'm') || stristr($birth_date, 'y')){
        echo "The form submission is missing values.";
        die();
    } else {
        try {
            User::create(array(
            'username'    => $name,
            'email'       => $email,
            'password'    => $pass,
            'ip'          => $ip,
            'signup'      => $now,
            'last_login'  => $now,
            'notif_check' => $now
            ));

            Useroptions::create(array(
            'username'   => $name,
            'country_id' => $country,
            'gender'     => $gender,
            'birth_date' => $birth_date
            ));
        } catch (Exception $e) {
            echo $e;
            die();
        }
        if (!mkdir("user_data/$name/photos", 0777, true) ) {
            echo 'Failed to create resources. Please contact site administrators';
            die();
        }
        if (!mkdir("user_data/$name/avatar", 0777, true) ) {
            echo 'Failed to create resources. Please contact site administrators';
            die();
        }
        
        // Email

        $to = $email;
        $from = 'responder@social.gavadinov.com';
        $subject = 'The Awesome Network Account Activation';

        $headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

        $message = '
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <title>
                    The Awesome Network Message
                </title>
            </head>
            <body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
                <div style="padding:10px; background:url(http://social.gavadinov.com/img/header-background.png); font-size:24px; color:#eee;">
                    <a href="http://www.social.gavadinov.com">
                        <img src="http://social.gavadinov.com/img/logo.png" width="135" height="50" alt="awesome network" style="border:none; float:left; margin-top: 38px;">
                    </a>The Awesome Network Account Activation
                </div>
                <div style="padding:24px; font-size:17px;">Hello, '.$name.'.
                    <br>
                    <br>
                    <a href="http://www.social.gavadinov.com/activation/'.$name.'/'.$email.'/'.$pass.'">Click here to activate your account, young padawan.
                    </a>
                    <br>
                    <br>
                    Login after successful activation using your:
                    <br>
                    <br>
                    * E-mail Address: 
                    <b>
                        '.$email.'
                    </b>
                    <br>
                    or
                    <br>
                    * Username:
                    <b>
                        '.$name.'
                    </b>
                </div>
            </body>
        </html>
        ';
        mail($to, $subject, $message, $headers);

        echo '<span class="text-success">Success. Check your email for confirmation code.<br>(check the spam folder)</span>';
        die();
    }    
}

/*
***********************
** =LogIn
***********************
*/
if (isset($_POST['username']) ) {
    logIn('username');

}

if (isset($_POST['email']) ) {
    logIn('email');

}

/*
***********************
** =View
***********************
*/
$countries = Country::all();

$script = "<script src='js/login-reg.js'></script>";

view("views/login", array(
    'countries'     => $countries,
    'title'         => 'LogIn',
    'script_bottom' => $script,
    'header' => 'header.login.php',
    'local' => $local
    ));
?>