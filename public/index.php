<?php
require_once dirname(__FILE__) . "/../common/config/config.php";

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<style>
			.chesspiece
			{
				font-size: 55px;
			}
			
			td 
			{
				width: 10%;
				height: 10%;
			}
			
			td .chessLocationIdentifiers
			{
				width: 15px;
			}
			
		</style>
		
	</head>

	<body>
		<?php 
		
			
		?>
		<table border="1" cellspacing="0" style="width: 100%; height: 80%; text-align: center;">
			
			<tr >
				<td class="chessLocationIdentifiers">
					
				</td>
				<?php foreach (range('a', 'h') AS $columnLetter): ?>
				<td class="chessLocationIdentifiers">
					<?php echo $columnLetter; ?>
				</td>
				<?php endforeach; ?>
				<td class="chessLocationIdentifiers">
					
				</td>
			</tr>
			
			<?php 
			
				$draw = new \Libs\SimpleDrawHelper();
			
				$piece1 = new \Libs\ChessPiece("pawn", "white");
			
				$board = new \Libs\ChessBoard(); //$board->settleUpPiecesForNewGame();
				
				$player1 = new \Libs\Player("white");
				$player2 = new \Libs\Player("black");
				$game = new \Libs\ChessGame($player1, $player2, $board);
				$engine = new \Libs\GameEngine($game);
				
				
				
				
				$relativeField = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(4,'d'));
				$relativeField->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::KNIGHT, "white"));
				
				$relativeField2 = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(6,'e'));
				$relativeField2->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::KING, "black"));
//				
//				$relativeField3 = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(4,'f'));
//				$relativeField3->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::ROOK, "black"));
//				
//				$relativeField4 = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(6, 'f'));
//				$relativeField4->setChessPiece(new Libs\ChessPiece(Enums\ChessPieceType::ROOK, 'white'));
				
				foreach($engine->getAllPossibleMovementsForKnight($relativeField) AS $field)
				{
					$field->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::FLAG, "black"));
				}
				
				
				
				
				
				$rowNum = 8; $columnNum = 0;
				foreach ($board->getBoardMatrix() AS $row => $columns):
					
			?>
			
			<tr>
				
				<td class="chessLocationIdentifiers">
					<?php echo $rowNum; ?>
				</td>
				
				<?php foreach ($columns AS $boardSquare): ?>
				<td style="background-color: <?php echo ($boardSquare->getColor() == 'white') ? 'white' : '#dddddd'; ?>">
					<?php /* @var $boardSquare \Libs\ChessBoardSquare */ 
					if ( ! is_null($boardSquare->getChessPiece())): ?>
						<span class="chesspiece">
							<?php echo $draw->getChessPieceSymbol($boardSquare->getChessPiece()) ?>
						</span>
					<?php endif; ?>
				</td>
				
				<?php endforeach; ?>
				
				<td style="width: 2%">
					<?php echo $rowNum; ?>
				</td>
				
			</tr>
			
			<?php 
					$rowNum--;
				endforeach; 
			?>
			
			
			<tr class="chessLocationIdentifiers">
				<td>
					
				</td>
				<?php foreach (range('a', 'h') AS $columnLetter): ?>
				<td>
					<?php echo $columnLetter; ?>
				</td>
				<?php endforeach; ?>
				<td>
					
				</td>
			</tr>
			
		</table>
	</body>

</html>