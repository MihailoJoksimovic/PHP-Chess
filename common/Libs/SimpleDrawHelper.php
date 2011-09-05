<?php

namespace Libs;

/**
 * Simple helper containing some useful functions to interact with Chess Game
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class SimpleDrawHelper
{
	/**
	 * Maps piece type and color to it's Unicode Character
	 * 
	 * @var array
	 */
	private $type_2_char;
	
	public function __construct()
	{
		$this->type_2_char = array(
			\Enums\Color::WHITE => array(
				\Enums\ChessPieceType::BISHOP	=> '♗',
				\Enums\ChessPieceType::KING		=> '♔',
				\Enums\ChessPieceType::KNIGHT	=> '♘',
				\Enums\ChessPieceType::PAWN		=> '♙',
				\Enums\ChessPieceType::QUEEN	=> '♕',
				\Enums\ChessPieceType::ROOK		=> '♖',
			),

			\Enums\Color::BLACK => array(
				\Enums\ChessPieceType::BISHOP	=> '♝',
				\Enums\ChessPieceType::KING		=> '♚',
				\Enums\ChessPieceType::KNIGHT	=> '♞',
				\Enums\ChessPieceType::PAWN		=> '♟',
				\Enums\ChessPieceType::QUEEN	=> '♛',
				\Enums\ChessPieceType::ROOK		=> '♜',
			)
			
		);
	}
	
	/**
	 * Returns the Unicode Symbol representing the current piece
	 * 
	 * @param ChessPiece $piece
	 * @return char
	 */
	public function getChessPieceSymbol(ChessPiece $piece)
	{
		return $this->type_2_char[$piece->getColor()][$piece->getType()];
	}
	
}

