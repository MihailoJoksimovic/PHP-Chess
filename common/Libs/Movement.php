<?php

namespace Libs;

/**
 * Movement
 * 
 * Encapsulates all the data about a requested movement (i.e. piece1 wants to move
 * from a1 to b3).
 *
 * Please note that Movement object DOES NOT self-validate the move (i.e. does NOT 
 * check whether the move is valid or not!). This object only keeps the move request
 * but whether it is valid or not must be validated by separate class !
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class Movement
{
	/**
	 * Number of the move
	 * 
	 * @var int
	 */
	private $movementNumber;
	
	/**
	 * Field from which move was requested
	 * 
	 * @var ChessBoardSquare
	 */
	private $from;
	
	/**
	 * Destination field
	 * 
	 * @var ChessBoardSquare
	 */
	private $to;
	
	
	private $chessPiece;
	
	private $specialMove;
	
	public function __construct(ChessBoardSquare $from, ChessBoardSquare $to, $specialMove	= null)
	{
		$this->setFrom($from);
		$this->setTo($to);
		$this->setChessPiece($to->getChessPiece());
		$this->setSpecialMove($specialMove);
	}
	
	/**
	 * Returns the number of the movement
	 * 
	 * @return int
	 */
	public function getMovementNumber()
	{
		return $this->movementNumber;

	}

	/**
	 * Sets the movement number
	 * 
	 * @param type $movementNumber 
	 */
	public function setMovementNumber($movementNumber)
	{
		$this->movementNumber = $movementNumber;

	}

	/**
	 * Returns the source square from which move was requested
	 * 
	 * @return ChessBoardSquare
	 */
	public function getFrom()
	{
		return $this->from;

	}

	/**
	 * Sets the source square from which the move was requested
	 * 
	 * @param ChessBoardSquare $from 
	 */
	public function setFrom(ChessBoardSquare $from)
	{
		$this->from = $from;

	}

	/**
	 * Returns the destination square
	 * 
	 * @return ChessBoardSquare
	 */
	public function getTo()
	{
		return $this->to;

	}

	/**
	 * Sets the destination square
	 * 
	 * @param ChessBoardSquare $to 
	 */
	public function setTo(ChessBoardSquare $to)
	{
		$this->to = $to;

	}
	
	/**
	 *
	 * @return \Libs\ChessPiece
	 */
	public function getChessPiece()
	{
		return $this->chessPiece;

	}

	public function setChessPiece($chessPiece)
	{
		$this->chessPiece = $chessPiece;

	}
	
	public function isSpecialMove()
	{
		return (bool) $this->specialMove;
	}
	
	public function getSpecialMove()
	{
		return $this->specialMove;

	}

	public function setSpecialMove($specialMove)
	{
		$this->specialMove = $specialMove;

	}

	
	
	public function __toString()
	{
		return $this->from->getLocation()->getColumn() . $this->from->getLocation()->getRow()
				. $this->to->getLocation()->getColumn() . $this->to->getLocation()->getRow();
	}
}
