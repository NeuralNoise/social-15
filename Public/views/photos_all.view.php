<div class="row-fluid">
	<div class="span2 offset2">
		<h2>All Photos</h2>
	</div>	
</div>
<div class="row-fluid">
	<div class="span1 offset2">
		<a href="" class="muted" onclick="return false;">All</a>
	</div>
	<div class="span1">
		<a href="<?= $_GET['user'] . '/photos/albums' ?>">Albums</a>
	</div>
	<?php if ($my): ?>
		<div class="span2">
			<a href="./!upload">Create Album</a>
		</div>
	<?php endif ?>
</div>
<div class="row-fluid">
	<div class="span8 offset2">
		<?php foreach ($all_photos as $photo): ?>
			<?php 			
				list($width,$height) = getimagesize($photo->path);
				$id = 'allPhotos_photo-h';
				if ($width > $height) {
					$id = 'allPhotos_photo-w';
				}
			?>
			<a href="<?= $_GET['user'] . '/photos/all/' . $photo->p_id ?>" class="allPhotos_photoWrapper">
				<img src="<?= $photo->path ?>" alt="photo" id="<?= $id ?>" class="allPhotos_photo">
			</a>
		<?php endforeach ?>
	</div>
</div>
