var input = $("#image"),
	button = $("#upload"),
	album = $("#albumName"),
	st = $("#imgUpload-status")
    formdata = false,
    wrap = $(".imgUpload-wrapper");

button.on('click', function () {
	if (album.val() !== '') {
		input.click();
	} else {
		st.html(' Please fill in the album field.');
	}	
});

album.on('click', function () {
	emptyElement('imgUpload-status');
});

if (window.FormData) {  
    formdata = new FormData();
} 

input.change(function() { 
    wrap.html( "<img src='img/ajax-load-huge.gif'>");   
    var i = 0,
    len = this.files.length,
    img,
    reader,
    file;

    for ( ; i < len; i++ ) {
        file = this.files[i];

        if (!!file.type.match(/image.*/)) {
            if (formdata) {
                formdata.append("img[]", file);
            }
        } 
    }
    formdata.append("album", album.val());

	$.ajax({
        url: 'index.php',
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.indexOf('success') > -1) {
                var json = data.replace('success', ' '),
                    dataObj = $.parseJSON(json),
                    l = dataObj.length,
                    r = '';
                    console.log(json);
                wrap.hide();
                wrap.html('');
                for (var i = 0; i < l; i++) {
                    r += "<div class='imgUpload-photo'>" +
                              "<img src='" + dataObj[i].path + "' alt='IMG'> " +
                              "<br>" +
                              "<label for='"+ dataObj[i].p_id +"'>Add description: </label>" +
                              "<textarea name='"+ dataObj[i].p_id +"' id='"+ dataObj[i].p_id +"'></textarea>" +
                          "</div>";
                }
                r += "<br><button class='btn btn-primary-lighten' id='addDesc'>Submit</button>";
                wrap.html(r);
                wrap.fadeIn('slow');
            } else {
                wrap.html("<span class='text-error'>There was an error. Please try again!</span>");
            }
            
        },
        error: function() {
        	wrap.html("<span class='text-error'>There was an error. Please try again!</span>");
        }
    });
});