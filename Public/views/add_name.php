<div class="modal fade" id="addName">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">&times;</button>
		<h3>Please Add Your Credentials</h3>
	</div>

	<div class="modal-body">
		<div class="span2 offset1">
			<form onsubmit="return false;">
				<label for="addName-f_name">First Name: </label>
				<input type="text" name="addName-f_name" id="addName-f_name">
				<label for="addName-l_name">Last Name: </label>
				<input type="text" name="addName-l_name" id="addName-l_name">
			</form>
		</div>
	</div>

	<div class="modal-footer">
		<span id="addName-status" class="text-error"></span>
		<button class="btn btn-primary-lighten" onclick="addName();">Save</button>
	</div>
</div>