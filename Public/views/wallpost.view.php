<?php extract($wallpost) ?>
<div class="wallpostCard">
    <a href="./<?= $username ?>"><img src="<?= $avatar ?>" alt="avatar"></a> 
    <div class="wallpostCardName">
        <a href="./<?= $username ?>"><?= $full_name ?></a> > <a href="./<?= $this_user->username ?>"><?= $this_user->full_name ?></a>&nbsp;
        <small><span data-livestamp="<?= strtotime($date) ?>" class="liveStamp muted"></span></small>
    </div>
    <p class="wallpostCardBody"><?= $body ?></p>
    <div class="wallpostCardButtons">
        <?php if ($like_it): ?>
            <button class="btn btn-link" onclick="like('wallpost', '<?= $w_id ?>', 'unlike');">Unlike</button>
        <?php else: ?>
            <button class="btn btn-link" onclick="like('wallpost', '<?= $w_id ?>', 'like', '<?= $this_user->username ?>');">Like</button>
        <?php endif ?>
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
            <textarea class="addComment-input animated" placeholder="Write a comment" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {addComment('<?= $this_user->username . "', " . $w_id ?>, 'wallpost', '.commentsWrap'); return false;}"></textarea>
        </div>
       <?php require 'views/comments.php'; ?>
    </div>
</div>