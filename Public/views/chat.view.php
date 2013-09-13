<div class="row-fluid">
	<div class="span7 offset1" id="chatWrap">
		<div class="chat"></div>
		<textarea placeholder="Write something..." class="animated" onkeydown="if(event.keyCode == 13 && !event.shiftKey) {chatSend('<?= $this_user->username ?>'); return false;}"></textarea>
	</div>
</div>