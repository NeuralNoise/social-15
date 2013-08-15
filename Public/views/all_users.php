<div class="modal fade" id="allUsersModal">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h3>All Registered Users</h3>
    </div>
    <div class="modal-body">
        <?php foreach (User::all() as $user): ?>
            <a href="./<?= $user->username ?>"><?= person_DAO::get_full_name($user->username) ?></a>&nbsp; | &nbsp;
        <?php endforeach ?>
    </div>

</div>