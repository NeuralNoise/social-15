<div class="row-fluid">
	<div class="span8 offset2">
		<h2><?= $title ?></h2>
	</div>	
</div>

<?php if ($my && $album !== 'profile_pictures'): ?>
	<div class="row-fluid">
		<div class="span2 offset2">
			<a href="./upload/<?= $album ?>">Upload Photos</a>
		</div>
		<div class="span2">
			<a href="" onclick="removeAlbum('<?= $album ?>'); return false;">Remove Album</a>
		</div>

	</div>
<?php endif ?>

<div class="row-fluid">
	<div class="span8 offset2">
		<?php foreach ($photos as $photo): ?>
			<?php 			
				list($width,$height) = getimagesize($photo->path);
				$id = 'allPhotos_photo-h';
				if ($width > $height) {
					$id = 'allPhotos_photo-w';
				}
			?>
			<a href="<?= $user . '/photos/' . $photo->album . '/' . $photo->p_id ?>" class="allPhotos_photoWrapper">
				<img src="<?= $photo->path ?>" alt="photo" id="<?= $id ?>" class="allPhotos_photo">
			</a>
		<?php endforeach ?>
	</div>
</div>
<div id="status"></div>