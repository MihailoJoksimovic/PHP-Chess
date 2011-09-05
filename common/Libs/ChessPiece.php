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
	 * Foo bar
	 * 
	 * @param enum $type One of \Enums\ChessPieceType values
	 * @param enum $color One of \Enums\Color values
	 */
	public function __construct($type, $color)
	{
		$this->setType($type);
		
		$this->setColor($color);
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


}


