<?php 

extract($_POST);
$options = array('conditions' => array('game = ? AND player = ?', $game, $player));
$del = Games::all($options);
$json = array('username' => $player, 'full_name' => person_DAO::get_full_name($player), 'score' => $score);
if (!$del) {
	Games::create(array(
		'game' => $game,
		'player' => $player,
		'score' => $score
		));
	echo json_encode($json); die;
}
if (strcmp($score_order, 'asc') === 0) {
	if ($del && $del[0]->score >= $score) {
		$del[0]->delete();
		Games::create(array(
			'game' => $game,
			'player' => $player,
			'score' => $score
			));
		echo json_encode($json); die;
	}
} else if (strcmp($score_order, 'desc') === 0) {
	if ($del && $del[0]->score <= $score) {
		$del[0]->delete();
		Games::create(array(
			'game' => $game,
			'player' => $player,
			'score' => $score
			));
		echo json_encode($json); die;
	}
}



?>