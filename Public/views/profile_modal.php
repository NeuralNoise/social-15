<div class="modal fade" id="profileModal">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h3 id="allUsersHeader" hidden>All Registered Users</h3>
        <h3 id="allFriendsHeader" hidden>Friends</h3>
    </div>
    <div class="modal-body">
    	<div id="allUsers" hidden>
            <?php if ($my): ?>
                <?php foreach (User::all() as $user): ?>
                    <a href="./<?= $user->username ?>"><?= person_DAO::get_full_name($user->username) ?></a>&nbsp; | &nbsp;
                <?php endforeach ?>
            <?php endif ?>
    		
    	</div>
        <div id="allFriends" hidden>
    		<?php foreach ($this_user->dao->friends() as $fr): ?>
				<a href="./<?= $fr ?>"><?= person_DAO::get_full_name($fr) ?></a>&nbsp; | &nbsp;
			<?php endforeach ?>
    	</div>
    </div>

</div>