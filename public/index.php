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
			
				$board = new \Libs\ChessBoard(); $board->settleUpPiecesForNewGame();
				
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