<div class="row-fluid">
	<div class="span2 offset3">
		<h2>Albums</h2>
	</div>	
</div>
<div class="row-fluid">
	<div class="span1 offset3">
		<a href="<?= $_GET['user'] . '/photos/all' ?>">All</a>
	</div>
	<div class="span1">
		<a href="" class="muted" onclick="return false;">Albums</a>
	</div>
	<?php if (empty($this_user) ): ?>
		<div class="span2">
			<a href="./!upload">Create Album</a>
		</div>	
	<?php endif ?>	
</div>
<div class="row-fluid">
	<div class="span6 offset3 albumsHolder">
		<?php foreach (photo_DAO::albums($u->username) as $album): ?>
			<p><?= $album ?></p>
		<?php endforeach ?>
	</div>
</div>