username = $("header").attr('data-username');

function emptyElement(el) {
    $("#" + el).empty();
}

// restrict input
function restrict(elem) {
    var el = $("#" + elem);
    var reg = new RegExp;
    if (elem === 'email' || elem === 'albumName') {
        reg =  /[' " ,]/g;
    } else {
        reg = /[^a-z0-9]/gi;
    }
   el.val(el.val().replace(reg, ""));
}

// doesExist();
jQuery.fn.doesExist = function(){
        return jQuery(this).length > 0;
};

//Set Videos below header
$("iframe").each(function(){
	var ifr_source = $(this).attr('src');
	var wmode = "wmode=transparent";
	if(ifr_source.indexOf('?') != -1) {
		var getQString = ifr_source.split('?');
		var oldString = getQString[1];
		var newString = getQString[0];
			$(this).attr('src',newString+'?'+wmode+'&'+oldString);
	}
	else $(this).attr('src',ifr_source+'?'+wmode);
});

/*
***********************
** =Crop Avatar
***********************
*/
edit = false;
function changeCoords(c) {
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);	
}

function cropImage() {
	$('#target').Jcrop({
		minSize:     [150, 150],
        maxSize:     [350, 350],
        bgColor:     'black',
        bgOpacity:   0.4,
        setSelect:   [ 100, 100, 50, 50 ],
        aspectRatio: 1/1,
        onChange: changeCoords,
        onSelect: changeCoords
    });
}

function saveCrop() {
	var x = $('#x').val(),
		y =	$('#y').val(),
		w =	$('#w').val(),
		h =	$('#h').val();

	$.post('index.php', {'ajax':1, 'parser':'photo', 'x':x, 'y':y, 'w':w, 'h':h, 'crop':1, 'path':path}, function(data) {
		if (data === 'success') {
			location.reload();
		} else {
			$("#status").html(data);
		}
		
	});
}

$("#crop").on('hidden', function () {
	$('header').slideDown();
	if (!edit) {
		$.post('index.php', {'ajax':1, 'parser':'photo', 'crop':0, 'path':path}, function(data) {
		if (data === 'success') {
			location.reload();
		} else {
			$("#status").html(data);
		}
	});
	}
});

function editThumb() {
	edit = true;
	$.post("index.php", {'ajax':1, 'parser':'photo', 'editThumb':1}, function(data) {
		if (data[0] === 'u') {
			$("#target").attr('src', data);
			$('header').slideUp();
			$("#crop").modal();
			cropImage();
			path = data; // global
		} else {
			// $("#status").html(data);
		}
	});
}

/*
***********************
** =Comments
***********************
*/
function addComment(user, on, app, holder, th, path) {
	if (!th) {
		var inp = $(".addComment-input");
	} else {
		var inp = $(th);
	}
	if (!path) {
		var	path = $(location).attr('href');	
	}
		var holder = $(holder);
	if (inp.val()) {
		$.post("index.php", {'ajax':1, 'parser':'comment' , 'body':inp.val(), 'user':user, 'on':on, 'app':app, 'path': path, 'add_comment':1}, function(data) {
			if (data[0] === '<') {
				inp.val('');
				inp.height(20);
				inp.blur();
				holder.prepend(data);
				holder.mCustomScrollbar("update");
			} else{
				// $("#status").html(data);
			}
		});
	}	
}
/*
***********************
** =Notifications
***********************
*/
function clrNotif(th) {
	var th = $(th),
		title = $(document).attr('title');
	
	while (parseInt(title[0], 10) || title[0] == '(' || title[0] == ')') {
		title = title.replace(title[0], '');
		$(document).attr('title', title);
	}

	th.attr('id', 'notificationsChecked');
	th.attr('onclick', '');
	$("#numNotifications").hide();
	$.post('index.php', {'ajax':1, 'parser':'notification' , 'checked': 1}, function(data) {
		$("#status").html(data);
	});
}

$(document).ready(function() {
	var defTitle = $(document).attr('title');

	if (username !== undefined) { // If they are logged in
		setInterval(function() {
			$.post('index.php', {'ajax':1, 'parser':'notification', 'check': 1}, function(data) {
				if (data !== 'empty') {
					var dataObj = $.parseJSON(data),
						lastNotifTime = $(".notificationsDropdown>li:eq(1)>a>span").attr('data-time'),
						l = dataObj.length;
					for (var i = 0; i < l; i++) {
						if (dataObj[i].time > lastNotifTime) { // if this notification is not yet appended
							var title = '(' + l + ') ' + defTitle;
							$(document).attr('title', title);
							$(".notificationsDropdown>li:eq(0)").after(dataObj[i].append);
							$(".notificationsDropdown>li:eq(8)").remove();
							$("#notificationsChecked").attr('id', 'notificationsPending');
							$("#notificationsPending").attr('onclick', 'clrNotif(this);');
							$("#numNotifications").html(dataObj.length);
							$("#numNotifications").show();
						}
					}
				}				 
			});
		}, 10000);
	}
});

/*
***********************
** =Add Name
***********************
*/

$(document).ready(function() {
	if ($("#addName").doesExist()) {
		var modal = $("#addName");
		modal.modal("toggle");
	}
});

function addName() {
	var f_name = $("#addName-f_name").val(),
		l_name = $("#addName-l_name").val();
		console.log(f_name, l_name);
	if (f_name == '' || l_name == '') {
		$("#addName-status").html('Please fill in all fields.');
	} else if (f_name !== '' && l_name !== '') {
		$.post('index.php', {'ajax':1, 'parser':'edit', 'first_name':f_name,'last_name':l_name}, function(data) {
			if (data === 'success') {
				location.reload();
			}
		});
	}
}

$(window).unload(function() {
	if (username !== undefined) { // they are logged in
		$.post('index.php', {'ajax':1, 'parser':'logout', 'logout':1});
	}
});

// $(window).on('beforeunload', function(){
//   return 'Are you sure you want to leave?';
// });

/*
***********************
** =Search
***********************
*/
function searchSubmit() {
	var input = $(".search > input"),
		container = $(".searchResults");
	$.post('index.php', {'ajax':1, 'parser':'search', 'method':'normal', 'str':input.val()}, function(data) {
		try {
		   var json = $.parseJSON(data),
		   	   cards = '',
		   	   l = json.length;
		   for (var i = 0; i < l; i++) {
			    cards += "<div class='searchCard'>"+
							"<a href='./"+ json[i].username +"'><img src='"+ json[i].avatar +"' alt='avatar'></a>"+
							"<div class='searchCardInfo'>"+
								"<a href='./"+ json[i].username +"'>"+ json[i].full_name +"</a>"+
							"</div>"+
						  "</div>";
		   }

		   container.html('<button class="close" onclick="searchResultsClose();">&times;</button>' + cards);

		} catch (e) {
		   container.html('<button class="close" onclick="searchResultsClose();">&times;</button>' + 'No Results');   
		}
	});
	$(".cont").slideUp('slow', function() {
		$(".searchResultsWrap").slideDown('slow');
	});
}
function searchResultsClose() {
	$(".searchResultsWrap").slideUp('slow', function() {
		$(".cont").slideDown('slow');	
		$(".search > input").val('');
	});

}

/*
***********************
** =Likes
***********************
*/

function like(app, on, type, user, path) {
	if (!path) {
		var path = $(location).attr('href');	
	}
	
	$.post('index.php', {'ajax':1, 'parser':'like', 'type':type, 'on':on, 'app':app, 'user':user, 'path':path}, function(data) {
		if (data == 'success') {
			location.reload();
		} else {
			$("#status").html(data);
		}
	});
}

function getLikers(on, app) {
	$.post('index.php', {'ajax':1, 'parser':'like', 'type':'getLikers', 'on':on, 'app':app}, function(data) {
		try {
			var json = $.parseJSON(data),
		   	    cards = '',
		   	    l = json.length,
		   	    modal = document.createElement("DIV");
		   	modal = $(modal);
		   	modal.addClass('modal hide fade likeModal');
		   for (var i = 0; i < l; i++) {
			    cards += "<div class='likeCard'>"+
							"<a href='./"+ json[i].username +"'><img src='"+ json[i].avatar +"' alt='avatar'></a>"+
							"<div class='likeCardInfo'>"+
								"<a href='./"+ json[i].username +"'>"+ json[i].full_name +"</a>"+
							"</div>"+
						  "</div>";
		   }
		   modal.append('<div class="modal-header"><button class="close" data-dismiss="modal">&times;</button><h3>People Who Like This</h3></div>');
		   modal.append("<div class='modal-body'>"+ cards +"</div>")
		   modal.modal("toggle");
		} catch (e) {
			$("#status").html(data);	
		}	
	});
}