<?php extract($notifications) ?>
<header data-username="<?= $u->username ?>">
	<a href="./<?= $u->username ?>" class="avatarHeaderWrap"><img src="<?= $my_avatar ?>" alt="avatar" class="avatarHeader"> <b><?= $u->full_name ?></b></a>
	<div class="logo">
		<a href=".">
			<img src="img/logo.png" alt="Logo">
		</a>		
	</div>
	<div class="container-fluid">
		<form class="form-search search" onsubmit="searchSubmit(); return false;">
			<input type="text" class="input-medium search-query">
			<i class="icon-search" id="submitSearch" onclick="searchSubmit();"></i>
		</form>
		
		<div class="dropdown optionsWrap">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="options" title="Options"></a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a href="./<?= $u->username . '/edit' ?>">Edit Profile</a></li>
				<li><a href="./!games">Games</a></li>
				<li><a href="./!dependencies">Dependencies</a></li>
				<li><a href="./!logout">LogOut</a></li>
			</ul>
		</div>
		<div class="dropdown notificationsWrap">
			<?php if (empty($notif_new) ): ?>
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="notificationsChecked" title="Notifications"></a>
				<span id="numNotifications" class="notifications" hidden></span>		
			<?php else: ?>
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="notificationsPending" title="Notifications" onclick="clrNotif(this);">
					<span id="numNotifications" class="notifications"><?= count($notif_new)?></span>
				</a>				
			<?php endif ?>
			<ul class="dropdown-menu notificationsDropdown" role="menu" aria-labelledby="dLabel">
				<li id="notifHeader"><p>Notifications</p></li>
				<?php foreach ($notif_top as $notif): ?>
					<li>
						<a href="<?= $notif->path ?>">
							<?= $notif->message ?>
							<br>
							<span data-livestamp="<?= strtotime($notif->date) ?>" data-time="<?= strtotime($notif->date) ?>"></span>
						</a>
					</li>							
				<?php endforeach ?>
				<li><span><a href="./<?= $u->username ?>/notifications">All</a></span></li>
			</ul>
		</div>
		<?php if ($u->dao->msg_check()): ?>
			<a href="./!messages" id="headerMessagesNew">
				<span class="notifications" id="numMessages"><?= count($u->dao->msg_check())?></span>
			</a>
		<?php else: ?>
			<a href="./!messages" id="headerMessagesNone">
				<span class="notifications" id="numMessages" hidden></span>
			</a>
		<?php endif ?>
	</div>
</header>