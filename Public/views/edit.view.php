<div class="span5 offset5">
	<form onsubmit="return false;">
		<label for="f_name">First Name:</label>
		<input type="text" name="f_name" id="f_name" value="<?= $u->first_name ?>" onfocus="emptyElement('status')">
		<label for="l_name">Last Name:</label>
		<input type="text" name="l_name" id="l_name" value="<?= $u->last_name ?>" onfocus="emptyElement('status')">
		<label for="hometown">Hometown:</label>
		<input type="text" name="hometown" id="hometown" value="<?= $u->hometown ?>" onfocus="emptyElement('status')">
		<label for="curr_loc">Current Location:</label>
		<input type="text" name="curr_loc" id="curr_loc" value="<?= $u->curr_location ?>" onfocus="emptyElement('status')">
		<label for="high_school">High School:</label>
		<input type="text" name="high_school" id="high_school" value="<?= $u->high_school ?>" onfocus="emptyElement('status')">
		<label for="uni">University:</label>
		<input type="text" name="uni" id="university" value="<?= $u->university ?>" onfocus="emptyElement('status')">
		<label for="job_firm">Workplace:</label>
		<input type="text" name="job_firm" id="job_firm" value="<?= $u->job_firm ?>" onfocus="emptyElement('status')">
		<label for="job_title">Job Title:</label>
		<input type="text" name="job_title" id="job_title" value="<?= $u->job_title ?>" onfocus="emptyElement('status')">
		<br>
		<button id="edit" onclick="edit_profile(); " class="btn btn-primary-lighten">Save Changes</button>&nbsp;&nbsp;<span id="status" class="text-success"></span>
	</form>
</div>