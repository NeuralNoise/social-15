<div class="span8 offset1">
	<?php foreach ($all_games as $game): ?>
		<h2><a href="game/<?= $game ?>"><?= ucwords($game) ?></a></h2>
	<?php endforeach ?>
</div>