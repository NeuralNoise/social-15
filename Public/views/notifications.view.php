<div class="span8 offset3 allNotifications_wrap">
	<ul>
		<?php foreach ($all_notifications as $notif): ?>
			<li>
				<a href="<?= $notif->path ?>">
					<?= $notif->message ?>
				</a>
					<span data-livestamp="<?= strtotime($notif->date) ?>" data-time="<?= strtotime($notif->date) ?>" class="muted"></span>
			</li>
		<?php endforeach ?>
	</ul>
</div>