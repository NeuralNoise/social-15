<div class="modal hide fade">
    <div class="modal-header">
        <?php if ($success): ?>
            <h3>Succesfull Activation</h3>
        <?php else: ?>    
            <h3 class="text-error">There was a problem with your activation</h3>
        <?php endif ?>
        
    </div>
    <div class="modal-body">
        <div class="span4 offset1">
            <?php if ($success): ?>
                <h4>You'll be redirected shortly!</h4>
            <?php else: ?>    
                <h4>Please contact an administrator.</h4>
            <?php endif ?>
            
            
        </div>
    </div>
    <div class="modal-footer">
        <img src="img/ajax-load-huge.gif" alt="load">
    </div>
</div>

