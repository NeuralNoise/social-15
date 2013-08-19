<div class="row-fluid">
	<div class="span2 offset3">
		<h2>All Photos</h2>
	</div>	
</div>
<div class="row-fluid">
	<div class="span1 offset3">
		<a href="" class="muted" onclick="return false;">All</a>
	</div>
	<div class="span1">
		<a href="<?= $_GET['user'] . '/photos/albums' ?>">Albums</a>
	</div>
	<?php if (empty($this_user) ): ?>
		<div class="span2">
			<a href="./!upload">Create Album</a>
		</div>
	<?php endif ?>
</div>
<div class="row-fluid">
	<div class="span8 offset2">
		<?php if (empty($this_user) ): ?>
			<?php foreach (photo_DAO::all_photos($u->username) as $photo): ?>
				<?php 			
					list($width,$height) = getimagesize($photo->path);
					$class = 'allPhotos_photo-h';
					if ($width > $height) {
						$class = 'allPhotos_photo-w'; // !!!
					}
				?>
				<a href="<?= $_GET['user'] . '/photos/all/' . $photo->p_id ?>" class="allPhotos_photoWrapper">
					<img src="<?= $photo->path ?>" alt="photo" id="<?= $class ?>" class="allPhotos_photo">
				</a>					
			<?php endforeach ?>
		<?php else: ?>
			<?php foreach (photo_DAO::all_photos($this_user->username) as $photo): ?>
				<?php 			
					list($width,$height) = getimagesize($photo->path);
					$class = 'allPhotos_photo-h';
					if ($width > $height) {
						$class = 'allPhotos_photo-w';
					}
				?>
				<a href="<?= $_GET['user'] . '/photos/' . $photo->album . '/' . $photo->p_id ?>" class="allPhotos_photoWrapper">
					<img src="<?= $photo->path ?>" alt="photo" id="<?= $class ?>" class="allPhotos_photo">
				</a>
			<?php endforeach ?>
		<?php endif ?>
	</div>
</div>
