<button id="showScore" onclick="showScore()">High Scores</button>
<h1 id="heading">Minesweeper</h1>
<div class="timerWrap" id="timerWrap"><div id="timer" class="timer"></div></div>
<div id="stage" class="stage" oncontextmenu="javascript: return false;"></div>
<button id="res" onclick="location.reload()">Reset!</button>
<div id="mask">
	<div id="score">
		<h1>High Scores</h1>
		<table id="scoreTable">
			<tr><th>Name: </th> <th>Time(s): </th></tr>
			<?php foreach ($scores as $score): ?>
				<tr><th><a href="./<?= $score->player ?>"><?= person_DAO::get_full_name($score->player) ?></a> </th> <th><?= $score->score ?> </th></tr>
			<?php endforeach ?>
		</table>
		<button id="hideScore" onclick="hideScore()">Hide</button>
	</div>
</div>
<span class="status"></span>