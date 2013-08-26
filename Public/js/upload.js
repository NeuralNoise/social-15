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
                r += "<button class='btn btn-primary-lighten' id='addDesc' onclick='addDesc();'>Submit</button><br>";
                r += "<div id='addDescStatus' class='text-success'></div>";
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

/*
***********************
** =Descriptions
***********************
*/
function addDesc() {
    var button = $("#addDesc"),
        inputs = $("textarea"),
        data = '',
        l = inputs.length,
        status = $("#addDescStatus");
    button.hide();
    status.html('<img src="img/ajax-load-large.gif">');    
    for (var i = 0; i < l; i++) {
        var input = inputs.eq(i);
        if (input.val() !== '') {
            data += input.attr('name') + '/:/' + input.val() + '///';    
        }        
    }
    if (data !== '') {
        $.post('index.php', {'ajax':1, 'parser':'photo', 'addDescription':1, 'many':1, 'data':data}, function(data) {
            if (data == 'success') {
                status.html('Success');
                setTimeout(function(){location.assign('index.php')},700);
            } else {
                status.html(data);
            }
        });
    } else {
        status.html('Success');
        setTimeout(function(){location.assign('index.php')},700);
    }
}