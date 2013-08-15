<div class="container">
	<?php if ($this_user->gender === 'female'): ?>
		<h3 class="text-warning">Sorry <?= $this_user->first_name . ' ' . $this_user->last_name ?> has blocked you. You can't view her profile.</h3>
	<?php else: ?>
		<h3 class="text-warning">Sorry <?= $this_user->first_name . ' ' . $this_user->last_name ?> has blocked you. You can't view his profile.</h3>	
	<?php endif ?>
</div>