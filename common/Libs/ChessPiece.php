<?php

namespace Libs;

/**
 * ChessPiece
 * 
 * Represents and describes one single chess piece on the table. Piece is described
 * by its Color (Black / White) and Type (King, Queen, Pawn, etc.)
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class ChessPiece
{
	/**
	 * Piece type (e.g. Knight)
	 * 
	 * @var enum \Enums\ChessPieceType 
	 */
	private $type;
	
	/**
	 *
	 * @var enum \Enums\Color 
	 */
	private $color;
	
	/**
	 * Total number of movements this piece has made (0 means this piece hasn't moved yet)
	 * 
	 * @var int
	 */
	private $totalMoves;
	
	/**
	 * Foo bar
	 * 
	 * @param enum $type One of \Enums\ChessPieceType values
	 * @param enum $color One of \Enums\Color values
	 */
	public function __construct($type, $color)
	{
		$this->setType($type);
		
		$this->setColor($color);
		
		$this->totalMoves	= 0;
	}
	
	/**
	 * Returns the type of the piece
	 * @return enum One of \Enums\ChessPieceType values 
	 */
	public function getType()
	{
		return $this->type;

	}

	/**
	 * Sets the type of the piece
	 * 
	 * @param enum $type One of \Enums\ChessPieceType values
	 */
	public function setType($type)
	{
		$this->type = $type;
		
		return $this;

	}

	/**
	 * Returns the color of the piece (\Enums\Color::WHITE or \Enums\COLOR::BLACK)
	 * 
	 * @return enum One of \Enums\Color values
	 */
	public function getColor()
	{
		return $this->color;

	}

	/**
	 * Sets the color of the piece
	 * 
	 * @param enum $color One of \Enums\Color values
	 */
	public function setColor($color)
	{
		$this->color = $color;

		return $this;
	}

	/**
	 * Returns the number of movements this piece has made (0 means this piece
	 * hasn't moved yet)
	 * 
	 * @return int
	 */
	public function getTotalMoves()
	{
		return $this->totalMoves;
	}
	
	/**
	 * Returns TRUE if piece has been moved already, or FALSE if it didn't move yet
	 * 
	 * @return bool 
	 */
	public function hasMoved()
	{
		return (bool) $this->totalMoves;
	}
	
	/**
	 * Increase the total number of movements this piece has made by 1
	 */
	public function increaseMovements()
	{
		$this->totalMoves++;
	}
}


