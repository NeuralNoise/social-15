var avButton = $("#editAvatar"),
	avLoad = $("#avLoad"),
	avBorder = $(".avatarBorder");
avButton.hide();

avBorder.hover(function() {
	avButton.show();
}, function() {
	avButton.hide();
});

function uploadAvatar() {
	var input = $("#upAv"),
		file = false,
		status = $("#status");
	input.click();
	input.change(function() {
		avButton.remove();
		avLoad.show();
		$(".avatarBorder > a").css('cursor', 'default');
		$(".avatarBorder > a").click(function() {
			return false;
		});
		file = input.get(0).files[0];
		if (window.FormData) {
  			formdata = new FormData();
  		}
		if (formdata) {
			formdata.append("avatar", file);
			$.ajax({
				url: "index.php",
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (data) {
					avLoad.hide();
					if (data[0] === 'u') {						
						$("#target").attr('src', data);
						$("#crop").modal();
						$('header').slideUp();
						cropImage();
						path = data;
					} else {
						// alert(data);
						$("#status").html(data);
						// location.reload();
					}
					 
				}
			});
		}
	});
}

$("#showAllUsers").on('click', function () {
	$("#allUsersModal").modal("toggle");
	$('header').slideUp();
});
$("#allUsersModal").on('hidden', function () {
	$('header').slideDown();
});