<div class="modal hide fade myModal" id="crop">
	<div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <button id="save" onclick="saveCrop();" class="btn btn-info">Save</button>
        <h3 id="editThumb">Edit Thumbnail</h3>
    </div>
    <div class="modal-body">
    	<div id="crop-holder">    		
    		<img id="target" src="">
		</div>

		<input id="x" type="hidden">
        <input id="y" type="hidden">
        <input id="w" type="hidden">
		<input id="h" type="hidden">
    </div>

</div>