<div class="row-fluid">
	<div class="span11 offset1 imgUpload-wrapper">
		<form method="post" onsubmit="return false;">
			<label for="albumName">Album Name: </label>
			<input type="text" name="albumName" id="albumName">
			<input type="file" accept="image/png,image/jpg,image/gif,image/jpeg" multiple name="img[]" id="image" hidden>
		</form>

	    <button class="btn btn-primary" id="upload">Upload Photos</button> 
		<br><br>
	    <span class="text-error" id="imgUpload-status"></span>
	</div>
</div>