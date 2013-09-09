<div class="row-fluid">
    <div class="span2 sidebar">
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
    <div class="span6 writeOnWall">
            <form onsubmit="postToWall(); return false; ">
                <textarea placeholder="Write Something..." onkeydown="if(event.keyCode == 13 && !event.shiftKey) {postToWall('<?= $this_user->username ?>', '.wallposts'); return false;}"></textarea>
            </form>
        </div>
    <div class="span6 wallposts">
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
                        <button class="btn btn-link" onclick="like('wallpost', '<?= $w_id ?>', 'like', '<?= $this_user->username ?>');">Like</button>
                    <?php endif ?>
                    <a href="./<?= $this_user->username ?>/post/<?= $w_id ?>" class="btn btn-link">Comments<?= $comments_count ?></a>
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
                        <textarea class="addComment-input animated" placeholder="Write a comment" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {addComment('<?= $this_user->username . "', " . $w_id ?>, 'wallpost', '#commentsWrap > .mCustomScrollBox > .mCSB_container'); return false;}"></textarea>
                    </div>
                   <?php require 'views/comments.php'; ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <span class="status"></span>
</div>