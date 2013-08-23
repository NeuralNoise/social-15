<div class="row-fluid">
	<div class="span2">
	  <!--Sidebar content-->
	  <div class="avatarBorder">
	  		<img src="<?= $avatar ?>" alt="Avatar" class="avatar">
	  </div>
	  
	</div> <!-- End Sidebar -->
	<div class="span8">
		<?php if ($this_user->activated): ?>
			<h1><?= $title ?>'s Profile</h1>
			<ul>
				<li>Am I the owner of this profile: No</li>
				<li>Username: <?= ucfirst($this_user->username) ?></li>
			</ul>
			<?php if (empty($blocked_this_user) ): ?>
				<?php if (!empty($pending) ): ?>
					<button class="btn disabled">You have a pending friend request!</button>
					<br>
					<button class="btn btn-danger" id="revoke" <?= "onclick='revoke(\"$this_user->username\");'" ?>>Revoke Friend Request</button>&nbsp;&nbsp;<span id="revokeStatus" class="text-error"></span>
				<?php elseif (!empty($waiting)): ?>
					<button class="btn btn-success" id="accept" <?= "onclick='acceptFr(\"$this_user->username\");'" ?> >Accept Request</button>&nbsp;&nbsp;<span id="accStatus" class="text-error"></span>
				<?php else: ?>
					<button class="btn btn-success" id="add" <?= "onclick='addFr(\"$this_user->username\");'" ?>>Add Friend</button>&nbsp;&nbsp;<span id="addStatus" class="text-error"></span>
					<br><br>
					<button class="btn btn-danger" id="block" <?= "onclick='block(\"$this_user->username\");'" ?>>Block User</button>&nbsp;&nbsp;<span id="blockStatus" class="text-error"></span>
				<?php endif; ?>		
			<?php else: ?>
				<button class="btn btn-info" id="unblock" <?= "onclick='unblock(\"$this_user->username\");'" ?>>Unblock User</button>&nbsp;&nbsp;<span id="unblockStatus" class="text-error"></span>
			<?php endif ?>
		<?php else: ?>
			<?php if ($this_user->gender === 'female'): ?>
				<h3>This user has not yet activated her profile.</h3>
			<?php else: ?>
				<h3>This user has not yet activated his profile.</h3>
			<?php endif ?>
		<?php endif ?>
	</div>
</div>