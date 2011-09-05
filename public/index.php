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
			
		</style>
		
	</head>

	<body>
		<table border="1" cellspacing="0" style="width: 100%; height: 80%; text-align: center;">
			
			<?php 
			
				$draw = new \Libs\SimpleDrawHelper();
			
				$piece1 = new \Libs\ChessPiece("pawn", "white");
			
				$board = new \Libs\ChessBoard(); $board->settleUpPiecesForNewGame();
				foreach ($board->getBoardMatrix() AS $row => $columns):
			?>
			
			<tr>
				
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
				
			</tr>
			
			<?php endforeach; ?>
			
		</table>
	</body>

</html>