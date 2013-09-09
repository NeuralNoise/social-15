/*
***********************
** =Reg		
***********************
*/

function checkUsername() {
    var u = $("#username").val();
    if (u !== "") {
        var status = $("#userStatus");
        status.html('<img src="img/ajax-load.gif">');
        $.post('index.php', { usernamecheck: u }, function(data) {
            status.html(data);
        })
    }
}

function checkEmail() {
    var e = $("#email").val();
    if (e !== "") {
        var status = $("#emailStatus");
        status.html('<img src="img/ajax-load.gif">');
        $.post('index.php', { emailcheck: e }, function(data) {
            status.html(data);
        })
    }
}

function comparePass() {
    var pass1 = $("#password"),
        pass2 = $("#password2");
    if (pass1.val() !== '') {
        if (pass1.val() === pass2.val()) {
            $("#passStatus").html('<span class="text-success">Passwords match</span>');
        } else {
            $("#passStatus").html('<span class="text-error">Passwords DO NOT match!</span>');
        }
    }
}

function checkPass() {
    var th = $("#password");
    if (th.val().length < 6 && th.val() !== '') {
        $("#pass2Status").html('At least six characters!');
    } else {
        $("#pass2Status").html('');
    }
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}

function reg() {
    var u = $("#username").val(),
        p = $("#password").val(),
        p2 = $("#password2").val(),
        e = $("#email").val(),
        c = $("#country").val(),
        g = $(".btn-group > .active").html(),
        d = $("#year").val() + '-' + $("#month").val() + '-' + $("#day").val(),
        status = $("#regStatus");
    if (u === '' || p === '' || e === '' || c === '' || g === '') {
        status.html('Please fill in all the fields');
    } else if (p.length < 6) {
        status.html('Password must be at least six characters long!') 
    } else if (p !== p2){
        status.html('Passwords DO NOT match');
   } else if (!isValidEmailAddress(e)) {
       status.html('Not a valid email address');
    } else {
       status.html('<img src="img/ajax-load.gif">');
       $.post('index.php',{'u': u, 'p': p, 'e': e, 'c': c, 'g': g, 'd': d}, function(data) {
            status.html(data);
       });
    }
}


/*
***********************
** =LogIn
***********************
*/

function tick(id) {
	var th = $("#" + id);
	if (th.attr('class').indexOf('active', 0) === -1) {
		th.html("<img src='img/tick.png'>");
	} else {
		th.html("<img src='img/tick-empty.png'>");
	}
}
function log_in() {
	var name = $("#name").val(),
		pass = $("#pass").val(),
		remember = $("#remember").attr('class'),
		status = $("#logInStatus");
	if (remember.indexOf('active', 0) === -1) {
		remember = false;
	} else {
		remember = true;
	}
	if (name.indexOf('@', 0) === -1) {
		$.post('index.php', {'username': name, 'pass': pass, 'remember': remember}, function(data) {
			if (data === 'success') {
                location.reload();
            } else if (data === 'not_active') {
                location.assign('message.php?message=not_active');
            } else {
                status.html(data);
            }
		})
	} else {
        $.post('index.php', {'email': name, 'pass': pass, 'remember': remember}, function(data) {
            if (data === 'success') {
                location.reload();
            } else if (data === 'not_active') {
                location.assign('message.php?message=not_active');
            } else {
                status.html(data);
            }
        })
    }


}
