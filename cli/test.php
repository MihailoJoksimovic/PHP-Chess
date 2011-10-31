<?php
require_once dirname(__FILE__) . "/../common/config/config.php";

$sentence = "{Please|Porfavor|Common} make this {super|ultra|funny} sentence {spin|rotate} {quickly}";

echo shuffleItBaby($sentence);

function shuffleItBaby($sentence)
{
//	$word = "";
//	while(($sentence = preg_replace_callback("/(?<={)[\w\d\s|]+(?=})/i"
//		, function ($matches) {	 $matches = explode("|", $matches[0]);	 shuffle($matches);	return array_pop($matches);  }
//		, $sentence)))
//		{
//			$word = $sentence;
//		}
		
	while (preg_match("/(?<={)([\w\d\s]+\|)(?=})/i", $sentence))
	{
		$sentence	= preg_replace_callback("/(?<={)([\w\d\s]+|)(?=})/i"
		, function ($matches) {	 $matches = explode("|", $matches[0]);	 shuffle($matches);	return array_pop($matches);  }
		, $sentence);
	}
	
	return str_replace(array("{", "}"), "", $sentence);
}

die();
$draw = new \Libs\SimpleDrawHelper();

$piece1 = new \Libs\ChessPiece("pawn", "white");

$board = new \Libs\ChessBoard(); //$board->settleUpPiecesForNewGame();

$player1 = new \Libs\Player("white");
$player2 = new \Libs\Player("black");
$game = new \Libs\ChessGame($player1, $player2, $board);
$engine = new \Libs\GameEngine($game);

foreach (\Libs\ChessBoardHelper::getAllDiagonalFields($board, $board->getSquareByLocation(new Libs\Coordinates(1, 'g'))) AS $lists)
{
	foreach ($lists AS $list)
	{
		var_dump($list);
	}
}
		