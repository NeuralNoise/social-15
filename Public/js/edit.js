function edit_profile() {
	var f_name = $("#f_name"),
		l_name = $("#l_name"),
		hometown = $("#hometown"),
		curr_loc = $("#curr_loc"),
		high_school = $("#high_school"),
		university = $("#university"),
		job_firm = $("#job_firm"),
		job_title = $("#job_title");

	if (f_name.val() !== f_name.attr('value') ) {
		f_name.attr('value', f_name.val());
		f_name = f_name.val();
		
	} else {
		f_name = '';
	}
	if (l_name.val() !== l_name.attr('value') ) {
		l_name.attr('value', l_name.val());
		l_name = l_name.val();
	} else {
		l_name = '';
	}
	if (hometown.val() !== hometown.attr('value') ) {
		hometown.attr('value', hometown.val());
		hometown = hometown.val();
	} else {
		hometown = '';
	}
	if (curr_loc.val() !== curr_loc.attr('value') ) {
		curr_loc.attr('value', curr_loc.val());
		curr_loc = curr_loc.val();
	} else {
		curr_loc = '';
	}
	if (high_school.val() !== high_school.attr('value') ) {
		high_school.attr('value', high_school.val());
		high_school = high_school.val();
	} else {
		high_school = '';
	}
	if (university.val() !== university.attr('value') ) {
		university.attr('value', university.val());
		university = university.val();
	} else {
		university = '';
	}
	if (job_firm.val() !== job_firm.attr('value') ) {
		job_firm.attr('value', job_firm.val());
		job_firm = job_firm.val();
	} else {
		job_firm = '';
	}
	if (job_title.val() !== job_title.attr('value') ) {
		job_title.attr('value', job_title.val());
		job_title = job_title.val();
	} else {
		job_title = '';
	}

	$.post('index.php', {'ajax':1, 'parser':'edit', 'first_name':f_name,'last_name':l_name,'hometown':hometown,'curr_location':curr_loc,'high_school':high_school,'university':university,'job_firm':job_firm,'job_title':job_title}, 
		function(data){
			if (data === 'success') {
					$("#status").html('Information updated succesfully');
			} else {
				$("#status").html(data);
			}
		});
}