<?php 

$temp = glob("apps/*");
$all_games = array();
foreach ($temp as $game) {
	array_push($all_games, substr($game, 5));
}

if (isset($_GET['game']) ) {
	$game = strtolower($_GET['game']);
	$options = array('conditions' => array('game = ?', $game), 'group' => 'player', 'order' => 'score');
	$scores = Games::all($options);

	if (in_array($game, $all_games) ) {
		view('apps/'. $game .'/'. $game, array(
			'xView' => $xView,
			'script_bottom' => '<script src="apps/'. $game .'/js/main.js"></script>',
			'style' => '<link rel="stylesheet" href="apps/'. $game .'/css/style.css">',
			'scores' => $scores,
			'title' => ucfirst($game)
			));
	} else {
		header('Location: '. BASE_DIR);
	}
} else if (isset($_GET['games']) ) {
	view('views/games', array(
		'xView' => $xView,
		'all_games' => $all_games,
		'title' => 'Games'
		));
}

?>