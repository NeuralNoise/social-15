
/*
***********************
** =Friend System
***********************
*/


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
var wallpostInput = $(".writeOnWall > form > textarea"),
	sidebarDefHeight = $(".sidebar").height();

function postToWall(user, holder) {
	var input = wallpostInput,
		body = input.val(),
		holder = $(holder);
	if (body) {
		input.val('');
		input.blur();

		$.post('index.php', {'ajax':1, 'parser':'wallpost', 'body':body, 'on_user':user, 'type':'add'}, function(data) {
			try {
			   	var post = $.parseJSON(data),
			   	   container = document.createElement("DIV");
			   	container = $(container);
			   	container.addClass('wallpostCard');
			   	post = [
			   		'<a href="./'+ post.username +'"><img src="'+ post.avatar +'" alt="avatar"></a>',
			   		'<div class="wallpostCardName">',
                    	'<a href="./'+ post.username +'">'+ post.fullName +'</a>&nbsp;',
                    	'<small><span data-livestamp="'+ post.date +'" class="liveStamp muted"></span></small>',
                	'</div>',
                	'<p class="wallpostCardBody">'+ post.body +'</p>',
                	'<div class="wallpostCardButtons">',
                        '<button class="btn btn-link" onclick="like(\'wallpost\', \''+ post.w_id +'\', \'like\', \''+ post.username +'\');">Like</button>',
	                    '<a href="./'+ post.thisUser +'/post/'+ post.w_id +'" class="btn btn-link">Comments</a>',
	                '</div>',
	                '<div class="wallpostCardComments">',
	                    '<div class="addComment">',
	                        '<textarea class="addComment-input animated" placeholder="Write a comment" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {addComment(\''+ post.username +','+ post.w_id +', \'wallpost\', \'#commentsWrap > .mCustomScrollBox > .mCSB_container\'); return false;}"></textarea>',
	                    '</div>',
	                '</div>',
	                '<ul id="commentsWrap" class="commentsWrap">',
	                '</ul>'
			   	].join('');
			   	container.html(post);
			   	holder.prepend(container);
			} catch (e) {
			   $(".status").html(data);
			}
		});
	}
}

$('textarea').on('focus', function() {
	var input = $(this);
	if (!input.val()) {
		input.height(50);
	}
});
$('textarea').on('blur', function() {
	var input = $(this);
	if (!input.val()) {
		input.height(20);
		$(".sidebar").height(sidebarDefHeight);
	}	
});
$('textarea').on('keydown', function() {
	$(".sidebar").height($('body').height());
});

$(document).ready(function(){
    $('textarea').autosize({append: "\n"});
    $('textarea:last-child').blur();

});