<?php

require_once dirname(__FILE__) . "/../../common/config/config.php";

/**
 * kingMovements
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class TestKingMovements extends PHPUnit_Framework_TestCase
{
	/**
	 *
	 * @var \Libs\ChessGame
	 */
	private $game;
	
	/**
	 *
	 * @var \Libs\GameEngine
	 */
	private $engine;
	
	/**
	 *
	 * @var \Libs\ChessPiece
	 */
	private $king;
	
	public function setUp()
	{
		$this->game = new \Libs\ChessGame(new Libs\Player("white"), new Libs\Player("black"), new \Libs\ChessBoard());
		
		$this->engine = new \Libs\GameEngine($this->game);
		
		$this->king = new \Libs\ChessPiece("king", "white");
	}
	
	
	public function testKingCanMoveToAllNeighbourSquares()
	{
		\Libs\ChessBoardHelper::removeAllChessPieces($this->game->getChessBoard());
		
		$location = new \Libs\Coordinates(5, 'd');
		
		$testSquare = $this->game->getChessBoard()->getSquareByLocation($location);
		
		$testSquare->setChessPiece($this->king);
		
		$neigbourSquares	= \Libs\ChessBoardHelper::getAllNeighbourFields($this->game->getChessBoard(), $testSquare);
		
		foreach ($neigbourSquares AS $square)
		{
			$this->assertTrue($this->engine->isMovementAllowed($testSquare, $square), "King can move to all neighbour squares");
		}
	}
	
	
	public function testKingCantMoveNextToOpponentKing()
	{
		$blackKing	= new \Libs\ChessPiece("king", "black");
		
		$location = new \Libs\Coordinates(5, 'd');
		
		$testSquare = $this->game->getChessBoard()->getSquareByLocation($location);
		
		$testSquare->setChessPiece($blackKing);
		
		$forbiddenFields	= \Libs\ChessBoardHelper::getAllNeighbourFields($this->game->getChessBoard(), $testSquare);
		
		
		// Move king to each fild on table, except on forbidden fields and on location where black king is located
		foreach (range(1, 8) AS $row)
		{
			foreach (range('a', 'h') AS $column)
			{
				
				
				$newLocation	= $this->game->getChessBoard()->getSquareByLocation(new \Libs\Coordinates($row, $column));
				
				if ($newLocation->equal($testSquare) || $newLocation->isContainedIn($forbiddenFields))
				{
					continue;
				}
				
				$newLocation->setChessPiece($this->king);
				
				foreach ($forbiddenFields AS $forbiddenField)
				{
					$this->assertFalse($this->engine->isMovementAllowed($newLocation, $forbiddenField), "King can't move from $newLocation to $forbiddenField");
					$this->assertFalse($this->engine->isMovementAllowed($newLocation, $testSquare), "King can't move from $newLocation to $testSquare");
				}
				
				$newLocation->setChessPiece(null);
			}
		}
	}
	
	
	
	
	
}