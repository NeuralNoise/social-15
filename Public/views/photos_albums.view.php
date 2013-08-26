<div class="row-fluid">
	<div class="span2 offset2">
		<h2>Albums</h2>
	</div>	
</div>
<div class="row-fluid">
	<div class="span1 offset2">
		<a href="<?= $_GET['user'] . '/photos/all' ?>">All</a>
	</div>
	<div class="span1">
		<a href="" class="muted" onclick="return false;">Albums</a>
	</div>
	<?php if ($my): ?>
		<div class="span2">
			<a href="./!upload">Create Album</a>
		</div>	
	<?php endif ?>	
</div>
<div class="row-fluid">
	<div class="span10 offset2 albumsHolder">
		<?php foreach ($albums as $photo): ?>
			<?php 			
				list($width,$height) = getimagesize($photo->path);
				$id = 'allPhotos_photo-h';
				if ($width > $height) {
					$id = 'allPhotos_photo-w';
				}
			?>
			<a href="./<?= $this_user->username ?>/photos/album/<?= $photo->album ?>" class="allPhotos_photoWrapper">
				<p><?= mb_convert_case(replace_($photo->album), MB_CASE_TITLE, "UTF-8") ?></p>
				<img src="<?= $photo->path ?>" alt="img" id="<?= $id ?>" class="allPhotos_photo">

			</a>
		<?php endforeach ?>
	</div>
</div>