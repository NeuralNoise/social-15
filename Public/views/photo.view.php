<div class="row photoView">
	<a onclick="clickArrow('<?= BASE_DIR . $this_user->username . '/photos/' . $_GET['album'] . '/' .  $p->dao->previous($_GET['p_id'], $_GET['album'])->p_id ?>')" class="chevronLeft"></a>
	<h3 class="photoView_heading"><?= $title ?></h3>
	<a onclick="clickArrow('<?= BASE_DIR . $this_user->username . '/photos/' . $_GET['album'] . '/' .  $p->dao->next($_GET['p_id'], $_GET['album'])->p_id ?>')" class="chevronRight"></a>
	<div class="photoView_photo-wrapper">
		<div class="photoView_photo-holder">
			<?php if ($p->width >= $p->height): ?>
				<img src="<?= $p->path ?>" data-photoId="<?= $p->p_id ?>" alt="Photo" class="photoView_photo" id="photoView_photo-w" onload="onImgLoad();" >
			<?php else: ?>
				<img src="<?= $p->path ?>" data-photoId="<?= $p->p_id ?>" alt="Photo" class="photoView_photo" id="photoView_photo-h" onload="onImgLoad();" >
			<?php endif ?>
		</div>
		<div class="photoView_comments"> <!-- Comments -->
			<div class="beforeComments">
				<div class="profile">
					<div class="profilePic">
						<a href="./<?= $this_user->username ?>"><img src="<?= $avatar ?>" alt="avatar" class="avatarMini"></a>
					</div>
					<div class="nameDate">
						<h5><a href="./<?= $this_user->username ?>"><?= $this_user->full_name ?></a></h5>
						<span data-livestamp="<?= strtotime($p->upload_date) ?>" class="liveStamp muted"></span>
					</div>
				</div>

				<div class="description">
					<?php if ($my_photo): ?>
						<a href="" data-toggle="modal" data-target="#descriptionModal"><?= $p->description ?> <br><b> (Edit Description)</b></a>
						<?php include 'views/description.php'; ?>
					<?php else: ?>
						<p><?= $p->description ?></p>	
					<?php endif ?>				
				</div>

				<div class="photoLikes">
					<?php if ($likes_count > 0): ?>
						<?php if ($likes_count === 1): ?>
							<p><a href="./<?= $likes[0]->owner ?>"><?= person_DAO::get_full_name($likes[0]->owner) ?> </a> likes this.</p>	
						<?php else: ?>
							<p><a href="" onclick="getLikers('<?= $p->p_id ?>', 'photo'); return false; "><span id="numLikes"><?= $likes_count ?></span> people</a> like this.</p>
						<?php endif ?>
					<?php endif ?>
				</div>

				<?php if ($like_it): ?>
					<a href="" onclick=" like('photo', '<?= $p->p_id ?>', 'unlike'); return false;"><small>Unlike</small></a>
				<?php else: ?>
					<a href="" onclick=" like('photo', '<?= $p->p_id ?>', 'like', '<?= $this_user->username ?>'); return false;"><small>Like</small></a>
				<?php endif ?>
				
				<div class="addComment">
					<textarea class="addComment-input animated" placeholder="Write a comment" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {addComment('<?= $this_user->username . "', " . $p->p_id ?>, 'photo', '#commentsWrap > .mCustomScrollBox > .mCSB_container'); return false;}"></textarea>
					<br>
					<button onclick="addComment('<?= $this_user->username . "', " . $p->p_id ?>, 'photo', '#commentsWrap > .mCustomScrollBox > .mCSB_container');" class="btn btn-small" id="addCommentButton">Post</button>					
				</div>
			</div>
			<?php require 'views/comments.php'; ?>

		</div> <!-- End Comments -->
	</div>
</div>
<?php if ($my_photo): ?>
	<div class="row">
		<div class="span1 offset9">
			<button class="btn btn-link" id="deletePic" onclick="deletePhoto();">Delete</button>
		</div>
		<div class="span2">
			<button class="btn btn-link" id="makeProfile" onclick="makeProfilePic();">Make Profile Pic</button>
		</div>
	</div>
<?php endif ?>
<?php include 'views/crop_avatar.php' ?>
<div id="status"></div>