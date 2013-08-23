<?php require_once 'reg.view.php'; ?>

    <form name="login" id="login" onsubmit="return false;">
        <label for="name">Email or Username</label>
        <input type="text" name="email" id="name" placeholder="Email/Username" onfocus="emptyElement('logInStatus')">
        <label for="pass">Password</label>
        <input type="password" name="pass" id="pass" placeholder="Password" onfocus="emptyElement('logInStatus')">
    	<label for="remember">
            Remember Me <button type="button" class="btn" data-toggle="button" id="remember" onclick="tick('remember');"><img src='img/tick-empty.png'  alt="R"></button>
    	</label>
        <br>
        <button id="logIn" onclick="log_in();" class="btn btn-primary-lighten">LogIn</button>&nbsp;&nbsp;<span id="logInStatus"></span>
        <br><br>
        <a href="#">Forgotten your password?</a>
        <br><br>
        <span>You don't have an account?</span>
        <button type="button" class="btn btn-success btn-small" data-toggle="modal" data-target="#reg">SignUp</button>
        
    </form>
    
