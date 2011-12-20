<?php

namespace Libs;

/**
 * ChessGame
 * 
 * Encapsulates all data related to one single Chess Game (White Player, Black Player,
 * Chess Board, All movements that occured during the game).
 * 
 * This class should be instantiated ONLY when starting a new game. Otherwise,
 * it should be serialized / JSONed and stored to DataBase or any other storage media.
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class ChessGame
{
	/**
	 * White Player
	 * 
	 * @var Player
	 */
	private $whitePlayer;
	
	/**
	 * Black Player
	 * 
	 * @var Player
	 */
	private $blackPlayer;
	
	/**
	 * Chess Board
	 * 
	 * @var ChessBoard
	 */
	private $chessBoard;
	
	/**
	 * Array of all movements that occured during the game
	 * 
	 * @var array|Movement
	 */
	private $movements;
	
	/**
	 * Sets whether game is finished or not
	 * 
	 * @var bool
	 */
	private $gameFinished;
	
	/**
	 * Unique 10char game hash
	 * 
	 * @var string 
	 */
	private $gameHash;
	
	public function __construct(Player $whitePlayer, Player $blackPlayer, ChessBoard $chessBoard)
	{
		$this->movements	= array();
		
		$this->setWhitePlayer($whitePlayer);
		$this->setBlackPlayer($blackPlayer);
		$this->setChessBoard($chessBoard);
	}
	
	/**
	 *
	 * @return Player
	 */
	public function getWhitePlayer()
	{
		return $this->whitePlayer;

	}

	/**
	 *
	 * @param Player $whitePlayer 
	 */
	protected function setWhitePlayer($whitePlayer)
	{
		$this->whitePlayer = $whitePlayer;

	}

	/**
	 *
	 * @return Player
	 */
	public function getBlackPlayer()
	{
		return $this->blackPlayer;

	}

	/**
	 *
	 * @param Player $blackPlayer 
	 */
	protected function setBlackPlayer($blackPlayer)
	{
		$this->blackPlayer = $blackPlayer;

	}

	/**
	 *
	 * @return ChessBoard 
	 */
	public function getChessBoard()
	{
		return $this->chessBoard;

	}

	/**
	 *
	 * @param ChessBoard $chessBoard 
	 */
	protected function setChessBoard($chessBoard)
	{
		$this->chessBoard = $chessBoard;

	}
	
	public function addMovement(Movement $movement)
	{
		$this->movements[]	= $movement;
	}
	
	public function getMovement($index)
	{
		return (array_key_exists($index, $this->movements) ? $this->movements[$index] : false);
	}
	
	public function getAllMovements()
	{
		return $this->movements;
	}
	
	public function getTotalMovements()
	{
		return count($this->movements);
	}
	
	public function isGameFinished()
	{
		return $this->gameFinished;
	}
	
	public function setGameFinished($true_or_false)
	{
		$this->gameFinished = (bool) $true_or_false;
	}

	public function getGameHash()
	{
		return $this->gameHash;
	}
	
	public function setGameHash($hash)
	{
		$this->gameHash	= $hash;
	}
}
