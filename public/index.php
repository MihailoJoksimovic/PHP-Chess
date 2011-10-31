<?php

require_once dirname(__FILE__) . "/../common/config/config.php";
if (isset($_GET['reset']))
{
	unset($_SESSION['game']); header("Location: index.php");
}

ini_set('display_errors', 'on');
error_reporting(E_ALL);
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
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
		
		<script type="text/javascript">
			$(document).ready(function() {
				var selectedSquare = null;
				
				$("td.inactive").hover(
				function() {
					if ( ! $(this).hasClass('active'))
					{
						$(this).css('background-color', 'red').css('cursor', 'pointer');
					}
				},
				function() {
					if ( ! $(this).hasClass('active'))
					{
						$(this).css('background-color', $(this).attr('originalBgColor'));
					}
					
				});
				
				
				$("td").click(function(){
					if ($(this).hasClass('active'))
					{
						$(this).css('background-color', $(this).attr('originalBgColor'));
						$(this).removeClass('active').addClass('inactive');
					}
					else
					{
						$(".active").removeClass('active').addClass("inactive").css('background-color', $(this).attr('originalBgColor'));
						
						$(this).addClass("active").removeClass("inactive");
						
						$(this).css('background-color', 'blue').css('cursor', 'pointer');
						
						var row = $(this).attr("boardRow");
						var col = $(this).attr("boardColumn");
						
						
						if ($("#moveLocation").val().length == 0 || $("#moveLocation").val().length == 4)
						{
							$("#moveLocation").val(col + row);
						}
						else if ($("#moveLocation").val().length == 2)
						{
							$("#moveLocation").val($("#moveLocation").val() + col + row);
						}
					}
				});
			});
		</script>
		
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
			
				
				
				if ( ! isset($_POST['game']) && ! isset($_SESSION['game']))
				{
					echo "Loading new game !<br/>";
					$board = new \Libs\ChessBoard();
				
					$player1 = new \Libs\Player("white");
					$player2 = new \Libs\Player("black");
					$game = new \Libs\ChessGame($player1, $player2, $board);
					
					$game->getChessBoard()->settleUpPiecesForNewGame();
					
					$engine = new \Libs\GameEngine($game);
					
				}
				else
				{
					echo "Continuing existing game :-)<br/>";
					
					if (isset($_POST['game']))
					{
						$_SESSION['game'] = $_POST['game'];
						
						$game	= unserialize(base64_decode($_POST['game']));
					}
					elseif (isset($_SESSION['game']))
					{
						$game	= unserialize(base64_decode($_SESSION['game']));
					}
					
					$board = $game->getChessBoard();
					
					$engine = new \Libs\GameEngine($game);
					
					if ( ! preg_match("/^([a-h]\d){2}$/", $_POST['move']))
					{
						echo "Invalid movement: {$_POST['move']} !!!<br/>";
					}
					else
					{
						list($from_column, $from_row, $to_column, $to_row) = array(
							$_POST['move'][0], $_POST['move'][1], $_POST['move'][2], $_POST['move'][3],   
						);
						
						$chessBoardSquare = $board->getSquareByLocation(new Libs\Coordinates($from_row, $from_column));
						
						// Reset all settled flags :-) 
						foreach ($game->getChessBoard()->findChessPieces(new Libs\ChessPiece(\Enums\ChessPieceType::FLAG, "white")) AS $square)
						{
							$square->setChessPiece(null);
						}
						
						/* @var $chessBoardSquare \Libs\ChessBoardSquare */
						if ($chessBoardSquare && $chessBoardSquare->getChessPiece())
						{							
							
							
							$destination = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates($to_row, $to_column));
							
							if ($engine->isMovementAllowed($chessBoardSquare, $destination))
							{
								$chessBoardSquare->getChessPiece()->increaseMovements();
								
								// Move the piece to the selected position
								$destination->setChessPiece($chessBoardSquare->getChessPiece());

								$chessBoardSquare->setChessPiece(null);
								
//								if ($engine->isSquareUnderAttack($destination))
//								{
//									echo "You have just moved to square under attack :-( <br/>";
//								}
								
								$game->addMovement(new Libs\Movement($chessBoardSquare, $destination));
								
								
								
							}
							else
							{
								echo "INVALID MOVEMENT REQUESTED ! <br/>";
							}
							
							
							
						}
					}
					
				}
				
				echo "It's " . strtoupper($engine->getPlayerWhoseTurnIsNow()->getColor()) . " player turn !";
				
				
				
				
				
				
				
				
				
				
//				$relativeField = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(4,'d'));
//				$relativeField->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::KNIGHT, "white"));
//				
//				$relativeField2 = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(6,'e'));
//				$relativeField2->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::KING, "black"));
//				
//				$relativeField3 = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(4,'f'));
//				$relativeField3->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::ROOK, "black"));
//				
//				$relativeField4 = $game->getChessBoard()->getSquareByLocation(new Libs\Coordinates(6, 'f'));
//				$relativeField4->setChessPiece(new Libs\ChessPiece(Enums\ChessPieceType::ROOK, 'white'));
				
//				foreach($engine->getAllPossibleMovementsForKnight($relativeField) AS $field)
//				{
//					$field->setChessPiece(new Libs\ChessPiece(\Enums\ChessPieceType::FLAG, "black"));
//				}
				
				
				
				
				
				$rowNum = 8; $columnNum = 0;
				foreach ($board->getBoardMatrix() AS $row => $columns):
					
			?>
			
			<tr>
				
				<td class="chessLocationIdentifiers">
					<?php echo $rowNum; ?>
				</td>
				
				<?php foreach ($columns AS $boardSquare): ?>
				<td style="background-color: <?php echo ($boardSquare->getColor() == 'white') ? 'white' : '#dddddd'; ?>" originalBgColor="<?php echo ($boardSquare->getColor() == 'white') ? 'white' : '#dddddd'; ?>" class="inactive" boardRow="<?php echo $boardSquare->getLocation()->getRow(); ?>" boardColumn="<?php echo $boardSquare->getLocation()->getColumn(); ?>">
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
		
		<form name="main" method="POST" action="">
			<input type="text" name="move" id="moveLocation" size="4"></input>
			<input type="hidden" name="game" value="<?php echo base64_encode(serialize($game)); ?>" />
			<button type="submit">Submit</button>
		</form>
		
		<br/>
		
		<a href="?reset=1">Reset game</a>
	</body>

</html>