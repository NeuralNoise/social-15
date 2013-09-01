<div class="row-fluid">
	<div class="span2">
    <!--Sidebar content-->
	    <div class="avatarBorder">
	      <a href="./<?= $this_user->username ?>">
	        <img src="<?= $avatar ?>" alt="Avatar" class="avatar">
	      </a>
	    </div>
  	</div> <!-- End Sidebar -->
  	<div class="span8">
    	<h1>About</h1>
  		<br>
  	</div>
    <div class="span4">
    	<h3>Birthday: </h3>
    	<div class="aboutCard">
    		<p><b><?= $birthday ?></b></p>
    	</div>
    	<h3>Work: </h3>
    	<div class="aboutCard">
    		<p><b><?= mb_convert_case($this_user->job_title, MB_CASE_TITLE, 'utf8') ?></b> at <b><?= mb_convert_case($this_user->job_firm, MB_CASE_TITLE, 'utf8') ?></b></p>
    	</div>
    	<h3>Education: </h3>
    	<div class="aboutCard">
    		<?php if (preg_match_all('/[A-ZА-Я]/', $this_user->university)): ?>
    			<p>University: <b><?= $this_user->university ?></b></p>
    		<?php else: ?>
    			<p>University: <b><?= mb_convert_case($this_user->university, MB_CASE_TITLE, 'utf8') ?></b></p>
    		<?php endif ?>
    	</div>
    	<div class="aboutCard">
    		<?php if (preg_match('/[A-ZА-Я]/', $this_user->high_school)): ?>
    			<p>High School: <b><?= $this_user->high_school ?></b></p>
    		<?php else: ?>
    			<p>High School: <b><?= mb_convert_case($this_user->high_school, MB_CASE_TITLE, 'utf8') ?></b></p>
    		<?php endif ?>    		
    	</div>
    	<h3>Location: </h3>
    	<div class="aboutCard">
    		<p>Hometown: <b><?= mb_convert_case($this_user->hometown, MB_CASE_TITLE, 'utf8') ?></b></p>
    	</div>
    	<div class="aboutCard">
    		<p>Current Location: <b><?= mb_convert_case($this_user->curr_location, MB_CASE_TITLE, 'utf8') ?></b></p>
    	</div>
    </div>


  
</div>