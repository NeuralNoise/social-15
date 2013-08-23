<?php extract($notifications) ?>
<header data-username="<?= $u->username ?>">
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
				<li><a href="./!dependencies">Dependencies</a></li>
				<li><a href="./!logout">LogOut</a></li>
			</ul>	
		</div>
		<div class="dropdown notificationsWrap">
			<?php if (empty($notif_new) ): ?>
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="notificationsChecked" title="Notifications"></a>
				<span id="numNotifications" hidden></span>		
			<?php else: ?>
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="notificationsPending" title="Notifications" onclick="clrNotif(this);">
					<span id="numNotifications"><?= count($notif_new)?></span>
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
	</div>	
</header>