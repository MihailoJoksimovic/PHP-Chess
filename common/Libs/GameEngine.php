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

	
	
	
	
	
	
	
	
	
	
	protected function getAllPossibleMovementsForKing(ChessBoardSquare $chessBoardSquare)
	{
		$movements = array();
		
		// King can move one row up
		$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByCoordinates(
				$chessBoardSquare->getLocation()->getRow() + 1
				, $chessBoardSquare->getLocation()->getColumn()
		);
		
		// King can move one row down
		$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByCoordinates(
				$chessBoardSquare->getLocation()->getRow() - 1
				, $chessBoardSquare->getLocation()->getColumn()
		);
		
		
		// Convert the current column to integer, so we can add / substract from it
		$currentColumnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		// King can move one column to the left
		$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByCoordinates(
				$chessBoardSquare->getLocation()->getRow()
				, $currentColumnInt	- 1
		);
		
		// King can move one column to the right
		$movements[]	= $this->getChessGame()->getChessBoard()->getSquareByCoordinates(
				$chessBoardSquare->getLocation()->getRow()
				, $currentColumnInt	+ 1
		);
		
		
		
		
		
	}
	
}
