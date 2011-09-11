<?php

namespace Libs;

class GameEngine
{
	/**
	 *
	 * @var ChessGame
	 */
	private $chessGame;
	
	public function __construct(ChessGame $chessGame)
	{
		$this->setChessGame($chessGame);
	}
	
	/**
	 *
	 * @return ChessGame
	 */
	public function getChessGame()
	{
		return $this->chessGame;
	}

	/**
	 *
	 * @param ChessGame $chessGame 
	 */
	protected function setChessGame(ChessGame $chessGame)
	{
		$this->chessGame = $chessGame;
	}

	
	
	
	
	public function getAllPossibleMovements(ChessBoardSquare $chessBoardSquare)
	{
		
	}

	
	
	
	
	
	
	
	
	
	/**
	 * Returns the array of ALL possible ChessBoardSquare's where KING can move
	 * from his current position.
	 * 
	 * @param ChessBoardSquare $chessBoardSquare
	 * @return array|ChessBoardSquare
	 * @todo Implement Castling movement
	 */
	public function getAllPossibleMovementsForKing(ChessBoardSquare $chessBoardSquare)
	{
		$movements = array();
		
		// King can move one row up
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
					new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + 1
						, $chessBoardSquare->getLocation()->getColumn()
					)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		
		// King can move one row down
		try 
		{
			$location = new Coordinates($chessBoardSquare->getLocation()->getRow() - 1, $chessBoardSquare->getLocation()->getColumn());

			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
					$location
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		
		// Convert the current column to integer, so we can add / substract from it
		$currentColumnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		
		// King can move one column to the left
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
					new Coordinates(
						$chessBoardSquare->getLocation()->getRow()
						, chr($currentColumnInt - 1)
					)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		// King can move one column to the right
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
					new Coordinates(
						$chessBoardSquare->getLocation()->getRow()
						, chr($currentColumnInt + 1)
					)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		
		// King can move one field diagonally up-left
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
					$chessBoardSquare->getLocation()->getRow() + 1
					, chr($currentColumnInt	- 1)
				)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		// King can move one field diagonally up-right
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
					$chessBoardSquare->getLocation()->getRow() + 1
					, chr($currentColumnInt	+ 1)
				)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		
		// King can move one field diagonally down-left
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
					$chessBoardSquare->getLocation()->getRow() - 1
					, chr($currentColumnInt	- 1)
				)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		// King can move one field diagonally down-right
		try 
		{
			$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
					$chessBoardSquare->getLocation()->getRow() - 1
					, chr($currentColumnInt	+ 1)
				)
			);
		}
		catch (\Exception $e)
		{
			// Ooops, invalid movement :-D
		}
		
		
		// TODO: Add Castling to possible movements (if allowed)
		//
		// Castling is allowed only if the following conditions are fully met:
		// 
		//		- Neither of the pieces involved in castling may have been previously moved during the game.
		//		- There must be no pieces between the king and the rook.
		//		- The king may not currently be in check, nor may the king pass 
		//			through squares that are under attack by enemy pieces, 
		//			nor move to a square where it is in check.
		
		
		
		//
		// Remove invalid movements
		//
		
		$_movements = $movements;
		
		foreach ($_movements AS $key => $destinationField)
		{
			// If there is chess piece of the same color on the destination field
			// movement isn't possible !
			
			if ($this->getChessGame()->getChessBoard()->getSquareByLocation($destinationField->getLocation())->getChessPiece())
			{
				unset($movements[$key]);
			}
			
		}
		
		
		return $movements;
	}
	
	
	public function getAllPossibleMovementsForQueen()
	{
		
	}
	
}
