<div class="row-fluid">
	<div class="span7 offset1" id="chatWrap">
		<div class="chat">
			<?php foreach ($messages as $message): ?>
			<?php $time = date('H:i', strtotime($message->date) ) ?>
				<?php if (strcmp($message->from_user, $u->username) === 0): ?>
					<div class="card">
						<a href="<?= $u->username ?>"><img src="<?= $u->avatar ?>" alt="avatar" class="avatar"></a>
						<div class="name">
							<a href="<?= $u->username ?>"><?= $u->full_name ?></a>
							<small><span data-livestamp="<?= strtotime($message->date) ?>" title="<?= $time ?>" class="liveStamp muted"></span></small>
						</div>
						<p class="msg"><?= $message->msg ?></p>
					</div>
				<?php else: ?>
					<div class="card">
						<a href="<?= $this_user->username ?>"><img src="<?= $this_user->avatar ?>" alt="avatar" class="avatar"></a>
						<div class="name">
							<a href="<?= $this_user->username ?>"><?= $this_user->full_name ?></a>
							<small><span data-livestamp="<?= strtotime($message->date) ?>" title="<?= $time ?>" class="liveStamp muted"></span></small>
						</div>
						<p class="msg"><?= $message->msg ?></p>
					</div>	
				<?php endif ?>
			<?php endforeach ?>

		</div>
		<p id="writing" class="muted" ></p>
		<textarea placeholder="Write something..." class="animated" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {chatSend('<?= $this_user->username ?>'); return false;} else {writing('<?= $this_user->username ?>')}" autofocus></textarea>
	</div>
</div>
<input type="text" value='<?= $me ?>' class="hidden" id="me">
<input type="text" value='<?= $you ?>' class="hidden" id="you">