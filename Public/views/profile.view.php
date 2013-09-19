<div class="row">
    <div class="span3 sidebar">
        <!--Sidebar content-->
        <div class="avatarBorder">
            <?php if ($avatar[0] !== 'i'): ?>
                <a href="<?= $this_user->username . '/photos/profile_pictures/' .  $this_user->avatar_id ?>">
            <?php endif ?>
                <img src="<?= $avatar ?>" alt="Avatar" class="avatar">
                <img src="img/ajax-load-large.gif" alt="loading..." id="avLoad" hidden>
            <?php if ($avatar[0] !== 'i'): ?>
                </a>
            <?php endif ?>
            <?php if ($my): ?>
                <div class="dropdown">
                    <button class="btn btn-mini btn-info dropdown-toggle" id="editAvatar" data-toggle="dropdown">
                        <i class="icon-edit icon-white"></i> Edit &nbsp;&nbsp;&nbsp;
                        <b class="caret"></b>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="editAvatar">
                        <li><a class="point" onclick="uploadAvatar()"><i class="icon-upload"></i> Upload</a></li>
                        <li><a class="point" onclick="editThumb()"><i class="icon-pencil"></i> Edit Thumbnail</a></li>
                    </ul>
                </div>
            <?php endif ?>
        </div>
        <div class="sidebarButtons">
            <?php if (!$my): ?>
                <button class="btn btn-danger" id="remFr" <?= "onclick='remFr(\"$this_user->username\");'" ?>>Unfriend</button>
                <br>
                <a href="./messages/<?= $this_user->username ?>" class="btn btn-success">Message</a>
            <?php endif ?>
            <a href="<?= $this_user->username . '/photos/all' ?>" class="btn btn-info" id="showPictures">Photos</a>
            <a href="./<?= $this_user->username ?>/about" class="btn btn-info">About</a>
            <?php if ($my): ?>
                <!-- <a href="" class="btn btn-info" id="showAllUsers" onclick="return false;" title="Временно!">All Users</a> -->
            <?php endif ?>
            <a href="" class="btn btn-info" id="showAllFriends" onclick="return false;" title="Временно!">Friends (<?= $this_user->dao->friend_count() ?>)</a>
        </div>
    </div> <!-- End Sidebar -->
    <div class="span8">
        <h1><?= $title ?>'s Profile</h1>
    </div>
    <div class="span7 writeOnWall">
        <form onsubmit="postToWall(); return false; ">
            <textarea placeholder="Write Something..." onkeydown="if(event.keyCode == 13 && !event.shiftKey) {postToWall('<?= $this_user->username ?>', '.wallposts'); return false;}"></textarea>
        </form>
        <br>
    </div>
    <div class="span7 wallposts">
        <?php foreach ($wallposts as $wallpost): ?>
        <?php extract($wallpost) ?>
            <div class="wallpostCard">
                <a href="./<?= $username ?>"><img src="<?= $avatar ?>" alt="avatar"></a> 
                <div class="wallpostCardName">
                    <a href="./<?= $username ?>"><?= $full_name ?></a>&nbsp;
                    <small><span data-livestamp="<?= strtotime($date) ?>" class="liveStamp muted"></span></small>
                </div>
                <p class="wallpostCardBody"><?= $body ?></p>
                <div class="wallpostCardButtons">
                    <?php if ($like_it): ?>
                        <button class="btn btn-link" onclick="like('wallpost', '<?= $w_id ?>', 'unlike');">Unlike</button>
                    <?php else: ?>
                        <button class="btn btn-link" onclick="like('wallpost', '<?= $w_id ?>', 'like', '<?= $this_user->username ?>', './<?= $this_user->username ?>/post/<?= $w_id ?>');">Like</button>
                    <?php endif ?>
                    <a href="./<?= $this_user->username ?>/post/<?= $w_id ?>" class="btn btn-link">Comments <span id="commentsCount_<?= $w_id ?>"><?= $comments_count ?></span></a>
                </div>
                <?php if ($likes_count > 0): ?>
                    <?php if ($likes_count === 1): ?>
                        <p class="likes"><a href="./<?= $likes[0]->owner ?>"><?= person_DAO::get_full_name($likes[0]->owner) ?> </a> likes this.</p>  
                    <?php else: ?>
                        <p class="likes"><a href="" onclick="getLikers('<?= $w_id ?>', 'wallpost'); return false; "><span id="numLikes"><?= $likes_count ?></span> people</a> like this.</p>
                    <?php endif ?>
                <?php endif ?>
                <div class="wallpostCardComments">
                    <div class="addComment">
                        <textarea class="addComment-input animated" placeholder="Write a comment" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {addComment('<?= $this_user->username . "', " . $w_id ?>, 'wallpost', '#<?= $wallpost_comment_wrap ?>', this, './<?= $this_user->username ?>/post/<?= $w_id ?>'); incrementComments('#commentsCount_<?= $w_id ?>'); return false;}"></textarea>
                    </div>
                   <?php require 'views/comments.php'; ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <span class="status"></span>
</div>

<?php if ($my): ?>
    <form method="post" onsubmit="return false;" hidden>
        <input type="file" id="upAv" name="avatar" accept="image/png,image/jpg,image/gif,image/jpeg">
    </form>
    <?php include 'views/crop_avatar.php'; ?>
<?php endif ?>
<?php include 'views/profile_modal.php'; ?>