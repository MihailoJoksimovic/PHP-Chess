<?php

namespace Enums;

class ChessPieceType extends Enum
{
	const KING	= 'king';
	
	const QUEEN	= 'queen';
	
	/**
	 * Top
	 */
	const ROOK	= 'rook'; 
	
	/**
	 * Lovac
	 */
	const BISHOP	= 'bishop';
	
	/**
	 * Konj
	 */
	const KNIGHT	= 'knight';
	
	/**
	 * Pijun
	 */
	const PAWN		= 'pawn';
	
	/**
	 * Flag used for testing purposes
	 */
	const FLAG		= 'flag';
	
}
