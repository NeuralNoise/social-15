// function on_load() {
// 	h   = img.height();
// 	w   = img.width();
// 	$(".photoView_comments").height(h);
// 	console.log(h);
// }
/*
***********************
** =Variables
***********************
*/
var photo = $(".photoView_photo"),
	holder = $('.photoView_photo-holder'),
	photoId = photo.attr('data-photoid');
/*
***********************
** =Switch Pictures
***********************
*/
var chevronRight = $(".chevronRight"),
	commentInput = $(".addComment-input");
function clickArrow(path) {
	location.assign(path);
}
function hover_chevron_right() {
	chevronRight.css('background-image', 'url(img/chevron_right_hover.png)');
}
function unHover_chevron_right() {
	chevronRight.css('background-image', 'url(img/chevron_right.png)');
}
holder.hover(function() { hover_chevron_right()},function() { unHover_chevron_right()} );
holder.click(function(){chevronRight.click();});
chevronRight.hover(function() { hover_chevron_right();},function() { unHover_chevron_right();} );

$(document).keydown(function(e){
	if (commentInput.is(':focus')) {
		
	} else {
		if (e.which == 37) {
	       $('.chevronLeft').click();
	       return false;
	    } else if (e.keyCode == 39) {
	       chevronRight.click();
	       return false;
	    }
	}
    
});

/*
***********************
** =Delete Photo
***********************
*/
function deletePhoto() {
	if (confirm("Do you really want to delete this photo?")) {
		$.post("index.php", {'ajax':1, 'parser':'photo', 'p_id': photoId, 'deletePhoto': 1}, function(data) {
			$("#status").html(data);
			if (data === 'success') {
				chevronRight.click();
			}
		});	
	}
}

/*
***********************
** =Make Profile Pic
***********************
*/
function makeProfilePic() {
	if (confirm("Do you really want to make this your profile picture?")) {
		$.post("index.php", {'ajax':1, 'parser':'photo', 'p_id': photoId, 'makeProfile': 1}, function(data) {
			if (data[0] === 'u') {						
				$("#target").attr('src', data);
				$('header').slideUp();
				$("#crop").modal();
				cropImage();
				path = data;
			} else {
				$("#status").html(data);
			}
		});
	}
}

/*
***********************
** =Comments
***********************
*/
function resizeTextArea() {
	var th = $('.addComment-input'),
		l = th.val().length,
		h = th.height();
		// console.log(l);
	if (l % 25 === 0 && l !== 0) {
		th.height(h + 20);
	}
}

function checkEnter(th) {
	var th = $(th),
		h = th.height();
	th.keydown(function(e) {

		if (e.which === 13) {
			// $("#addCommentButton").click();
			th.height(h + 20);
		}
	});
}

// scrollbar
(function($){
    $(window).load(function(){
        $("#commentsWrap").mCustomScrollbar({
        	theme:"dark-thick",
        	autoHideScrollbar: true
        });
    });
})(jQuery);

/*
***********************
** =Description
***********************
*/
var d = $("#descriptionModalSubmit"),
	desc = $("#descriptionModalInput"),
	defaultDesc = desc.val();

d.on('click', function () {
	var newDesc = desc.val(),
		modal = $("#descriptionModal");
		console.log(photoId);
	if (newDesc !== defaultDesc) {
		$.post('index.php', {'ajax':1, 'parser':'photo', 'addDescription':1, 'p_id':photoId, 'desc':newDesc}, function(data) {
			if (data == 'success') {
				modal.modal('hide');
				$(".description > a").html(newDesc + ' <br><b> (Edit Description)</b>');
				defaultDesc = newDesc;
			}
		});
	}
});