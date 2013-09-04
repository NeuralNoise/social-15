<div class="row-fluid">
    <div class="span2">
        <!--Sidebar content-->
        <div class="avatarBorder">
        <?php if ($avatar[0] !== 'i'): ?>
            <a href="<?= $this_user->username . '/photos/profile_pictures/' .  $this_user->avatar_id ?>">
        <?php endif ?>
            <img src="<?= $avatar ?>" alt="Avatar" class="avatar">
        <?php if ($avatar[0] !== 'i'): ?>
            </a>
        <?php endif ?>     	
        </div>
        <div class="sidebarButtons">
            <button class="btn btn-danger" id="remFr" <?= "onclick='remFr(\"$this_user->username\");'" ?>>Unfriend</button>
            <br>
            <a href="<?= $this_user->username . '/photos/all' ?>" class="btn btn-info" id="showPictures">Photos</a>
            <br>
            <a href="./<?= $this_user->username ?>/about" class="btn btn-info">About</a>
        </div>
    </div> <!-- End Sidebar -->
    <div class="span8">
        <h1><?= $title ?>'s Profile</h1>
    </div>
    <div class="span5 writeOnWall">
            <form onsubmit="postToWall(); return false; ">
                <input type="text" placeholder="Write Something...">
            </form>
        </div>
    <div class="span6 wallposts">
        <?php foreach ($wallposts as $wallpost): ?>
        <?php extract($wallpost) ?>
        <div class="wallpostCard">
            <a href="./<?= $username ?>"><img src="<?= $avatar ?>" alt="avatar"> <?= $full_name ?></a> &nbsp;<small><span data-livestamp="<?= strtotime($date) ?>" class="liveStamp muted"></span></small>
            <p><?= $body ?></p>
        </div>      
        <?php endforeach ?>    
    </div>
</div>