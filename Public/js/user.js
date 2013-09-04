function addFr(user2) {
	var conf = confirm("Do you really want to send a friend request?");
	if (conf) {
		var status = $("#addStatus");
		status.html('<img src="img/ajax-load.gif">');
		$.post('index.php', {'ajax':1, 'parser':'friend', 'user2': user2, 'type': 'add'}, function(data) {
			if (data === 'success') {
				location.reload();
			} else {
				status.html(data);
			}
		});
	} 	
}

function acceptFr(user1) {
	var conf = confirm("Do you really want to accept this friend request?");
	if (conf) {
			var status = $("#accStatus");
			status.html('<img src="img/ajax-load.gif">');
			$.post('index.php', {'ajax':1, 'parser':'friend', 'user1': user1, 'type': 'accept'}, function(data) {
				if (data === 'success') {
					location.reload();
				} else {
					status.html(data);
				}
			});
		}
}

function revoke(user2) {
	var conf = confirm("Do you really want to revoke the friend request?");
		if (conf) {
			var status = $("#revokeStatus");
			status.html('<img src="img/ajax-load.gif">');
			$.post('index.php', {'ajax':1, 'parser':'friend', 'user2': user2, 'type': 'revoke'}, function(data) {
				if (data === 'success') {
					location.reload();
				} else {
					status.html(data);
				}
			});
		}
}

function remFr(user2) {
	var conf = confirm("Do you really want to unfriend this user?");
		if (conf) {
			var status = $("#remFrStatus");
			status.html('<img src="img/ajax-load.gif">');
			$.post('index.php', {'ajax':1, 'parser':'friend', 'user2': user2, 'type': 'rem'}, function(data) {
				if (data === 'success') {
					location.reload();
				} else {
					status.html(data);
				}
			});
		}
}

function block(blockee) {
	var conf = confirm("Do you really want to block this user?");
	if (conf) {
		var status = $("#blockStatus"),
			reason = null;
		status.html('<img src="img/ajax-load.gif">');

		$.post('index.php', {'ajax':1, 'parser':'block', 'blockee': blockee, 'reason': reason, 'type': 'block'}, function(data) {
			if (data === 'success') {
				location.reload();
			} else {
				status.html(data);
			}
		});
	}
}

function unblock(blockee) {
	var conf = confirm("Do you really want to unblock this user?");
	if (conf) {
		var status = $("#unblockStatus");
		status.html('<img src="img/ajax-load.gif">');
		$.post('index.php', {'ajax':1, 'parser':'block', 'blockee': blockee, 'type': 'unblock'}, function(data) {
			if (data === 'success') {
				location.reload();
			} else {
				status.html(data);
			}
		});
	}
}

/*
***********************
** =Write On Wall
***********************
*/

function postToWall() {
	var input = $(".writeOnWall > form > input[type='text'");
	
}

$(".writeOnWall > form > input[type='text'").on('focus', function () {
	var input = $(this);
	input.height(50);
});
$(".writeOnWall > form > input[type='text'").on('blur', function () {
	var input = $(this);
	input.height(30);
});