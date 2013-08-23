<div class="row-fluid">
  <div class="span2">
    <!--Sidebar content-->
    <div class="avatarBorder">
    <?php if ($avatar[0] !== 'i'): ?>
      <a href="<?= $this_user->username . '/photos/profile_pictures/' .  $this_user->avatar_id ?>">
    <?php endif ?>
        <img src="<?= $avatar ?>" alt="Avatar" class="avatar">
    <?php if ($avatar[0] !== 'i'): ?>    
      </a>
    <?php endif ?>     	
    </div>
    <div class="sidebarButtons">
      <a href="<?= $this_user->username . '/photos/all' ?>" class="btn btn-info" id="showPictures">Photos</a>  
    </div>
  </div> <!-- End Sidebar -->
  <div class="span8">
      <h1><?= $title ?>'s Profile</h1>
	<ul>
		<li>Am I the owner of this profile: No</li>
		<li>Username: <?= ucfirst($this_user->username) ?></li>
		<li>Email: <?= $this_user->email ?></li>
	</ul>
	<button class="btn btn-danger" id="remFr" <?= "onclick='remFr(\"$this_user->username\");'" ?>>Unfriend</button>&nbsp;&nbsp;<span id="remFrStatus" class="text-error"></span>
  </div>
</div>
