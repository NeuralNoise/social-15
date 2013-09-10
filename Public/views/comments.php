<?php if (isset($w_id) ): ?>
    <ul id="<?= $wallpost_comment_wrap ?>" class="commentsWrap">
<?php else: ?>
    <ul id="commentsWrap" class="commentsWrap">    
<?php endif ?>
    <?php foreach ($comments_ar as $comment): ?>
    <?php extract($comment); ?>
        <li>
            <div class="comment_Avatar">
                <a href="./<?= $username ?>">
                    <img src="<?= $avatar ?>" alt="Avatar">
                </a>
            </div>
            <h6 class="comment_fullName"><a href="./<?= $username ?>"><?= $name ?></a></h6>
            <div class="comment_Body">
                <p><?= $body ?></p>
            </div>
            <span data-livestamp="<?= strtotime($date) ?>" class="liveStamp muted"></span>
            <?php if ($like_comment): ?>
                <a href="" onclick=" like('comment', '<?= $comment_id ?>', 'unlike'); return false;"><small>Unlike</small></a>
            <?php else: ?>
                <?php if (isset($w_id) ): ?>
                    <a href="" onclick=" like('comment', '<?= $comment_id ?>', 'like', '<?= $username ?>', './<?= $this_user->username ?>/post/<?= $w_id ?>'); return false;"><small>Like</small></a>
                <?php else: ?>
                    <a href="" onclick=" like('comment', '<?= $comment_id ?>', 'like', '<?= $username ?>'); return false;"><small>Like</small></a>    
                <?php endif ?>
                
            <?php endif ?>
            <?php if ($likes_count_comment > 0): ?>
                <?php if ($likes_count_comment === 1): ?>
                    <p><small><a href="./<?= $comment_likes[0]->owner ?>"><?= person_DAO::get_full_name($comment_likes[0]->owner) ?> </a> likes this.</small></p>   
                <?php else: ?>
                    <p><small><a href="" onclick="getLikers('<?= $comment_id ?>', 'comment'); return false;"><span id="numLikes"><?= $likes_count_comment ?></span> people</a> like this.</small></p>
                <?php endif ?>
            <?php endif ?>
        </li>
    <?php endforeach ?>

    <?php if (isset($comments_count_int) && $comments_count_int > 5): ?>
        <li>
            <a href="./<?= $this_user->username ?>/post/<?= $w_id ?>">View more comments...</a>
        </li>
    <?php endif ?>
</ul>