<div class="row-fluid">
	<div class="conversations span5 offset3">
		<ul>
			<?php foreach ($conversations as $conv): ?>
				<li>
					<a href="./messages/<?= $conv->from_user ?>" class="card">
						<img src="<?= person_DAO::get_avatar($conv->from_user) ?>" alt="avatar" class="avatar">
						<p><?= person_DAO::get_full_name($conv->from_user) ?></p>
					</a>
					<?php if ($conv->date <= $u->msg_check): ?>
						<img src="img/tick.png" class="tick" alt="tick">
					<?php else: ?>
						<img src="img/message.png" alt="message">
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>