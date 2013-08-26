function removeAlbum(album) {
	if (confirm('Are you sure you want to delete this album (ALL PHOTOS WILL BE LOST).')) {
		$.post('index.php', {'ajax':1, 'parser':'photo', 'removeAlbum':1, 'album':album, 'user':username}, function(data) {
			if (data == 'success') {
				location.assign('./');
			}
		});
	}
}