<?php

namespace Libs;

/**
 * Represents a one single square (field) found on the Chess Board
 * 
 * Square is described by its color (white or black) and the OPTIONAL piece
 * that is found on it (e.g. Pawn)
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class ChessBoardSquare
{
	/**
	 * Field color (white or black)
	 * 
	 * @var enum \Enums\Color
	 */
	private $color;
	
	/**
	 * Chess Piece currently positioned on this square (if any)
	 * 
	 * @var \Libs\ChessPiece [optional]
	 */
	private $chessPiece;
	
	/**
	 *
	 * @var Coordinates
	 */
	private $location;
	
	/**
	 *
	 * @param enum $color Field color (\Enums\Color::WHITE or \Enums\Color::BLACK)
	 * @param \Libs\ChessPiece $chessPiece Chess piece currently positioned on this field [optional]
	 */
	public function __construct($color, \Libs\ChessPiece $chessPiece = null)
	{
		$this->setColor($color);
		$this->setChessPiece($chessPiece);
	}
	
	/**
	 * Returns the field color
	 * 
	 * @return enum \Enums\Color::WHITE or \Enums\Color::BLACK
	 */
	public function getColor()
	{
		return $this->color;

	}

	/**
	 * Sets the field color
	 * 
	 * @param enum $color \Enums\Color::WHITE or \Enums\Color::BLACK
	 */
	public function setColor($color)
	{
		$this->color = $color;

		return $this;
	}

	/**
	 * Returns the piece currently positioned on this field (if any)
	 * 
	 * Returns NULL if field (square) is empty
	 * 
	 * @return \Libs\ChessPiece
	 */
	public function getChessPiece()
	{
		return $this->chessPiece;

	}

	/**
	 * Sets the piece currently positioned on this field
	 * 
	 * Pass NULL to remove any pieces found here
	 * 
	 * @param \Libs\ChessPiece $chessPiece 
	 */
	public function setChessPiece(\Libs\ChessPiece $chessPiece = null)
	{
		$this->chessPiece = $chessPiece;
		
		return $this;
	}

	/**
	 *
	 * @return Coordinates
	 */
	public function getLocation()
	{
		return $this->location;
	}

	public function setLocation(Coordinates $location)
	{
		$this->location = $location;

		return $this;
	}

	
}