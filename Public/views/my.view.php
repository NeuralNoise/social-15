<div class="row-fluid">
  <div class="span2 offset1 sidebar">
    <!--Sidebar content-->
    <div class="avatarBorder">
    <?php if ($avatar[0] !== 'i'): ?> <!-- If it's not the default picture include the link to the photo -->
      <a href="<?= $u->username . '/photos/profile_pictures/' .  $u->avatar_id ?>">
    <?php endif ?>
    		<img src="<?= $avatar ?>" alt="Avatar" class="avatar">
        <img src="img/ajax-load-large.gif" alt="loading..." id="avLoad" hidden>
    <?php if ($avatar[0] !== 'i'): ?>    
    	</a>
    <?php endif ?>
      <div class="dropdown">
        <button class="btn btn-mini btn-info dropdown-toggle" id="editAvatar" data-toggle="dropdown">
          <i class="icon-edit icon-white"></i> Edit &nbsp;&nbsp;&nbsp;
          <b class="caret"></b>
        </button>
        <ul class="dropdown-menu" aria-labelledby="editAvatar">
          <li><a class="point" onclick="uploadAvatar()"><i class="icon-upload"></i> Upload</a></li>
          <li><a class="point" onclick="editThumb()"><i class="icon-pencil"></i> Edit Thumbnail</a></li>
        </ul>
      </div>    	
    </div> <!-- End Avatar-->
    <span id="status"></span>
    <div class="sidebarButtons">
      <a href="<?= $u->username . '/photos/all' ?>" class="btn btn-info" id="showPictures">Photos</a>
      <br>
      <button class="btn btn-info" id="showAllUsers" title="Защото search-a не работи :)">All Users</button>
    </div>
    <?php include 'views/all_users.php'; ?>
    <!-- End of sidebar-->
  </div>
  <div class="span8 gray">
      <h1><?= $title ?>'s Profile</h1>
	<ul>
		<li>Am I the owner of this profile: Yes</li>
		<li>Username: <?= ucfirst($u->username) ?></li>
		<li>Email: <?= $u->email ?></li>
	</ul>
	
	<div class="frList">
		<h4>Friends:</h4>
		<?php foreach ($u->dao->friends() as $fr): ?>
			<a href="./<?= $fr ?>"><?= person_DAO::get_full_name($fr) ?></a> &nbsp; 
		<?php endforeach ?>
	</div>
  </div>
</div>

<form method="post" onsubmit="return false;" hidden>
	<input type="file" id="upAv" name="avatar" accept="image/png,image/jpg,image/gif,image/jpeg">
</form>
<?php include 'views/crop_avatar.php'; ?>