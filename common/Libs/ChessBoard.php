<?php

namespace Libs;

/**
 * ChessBoard
 *
 * Encapsulates the 8x8 array of ChessBoardSquares successfully representing/describing
 * a Chess Board
 * 
 * Contains methods for interacting with Board fields (squares)
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class ChessBoard
{
	/**
	 * Holds the 2-D array matrix, where first index represents the row (rank)
	 * while second index represents the column (file).
	 * 
	 * First index is always of INT type (1 - 8), while second index is CHAR (a - h)
	 * 
	 * For example, $boardMatrix[1][C] points to the first ROW and third COLUMN on the board
	 * 
	 * Each element on the matrix is an object of type ChessBoardSquare
	 * 
	 * @var array|\Libs\ChessBoardSquare
	 */
	private $boardMatrix;
	
	public function __construct()
	{
		// Populate the board matrix	
		
		for ($row = 1; $row <= 8; $row++)
		{
			$column_counter = 1;
			
			foreach (range('a', 'h') AS $column)
			{
				// Even rows (2, 4, 6, 8) have square colors ordered like:
				// white - black - white - black ....
				// 
				// Odd rows are opposite - black - white - black - white
				
				
				
				if ($row % 2 == 0) // Even row
				{
					if ($column_counter % 2 == 0) // Even column
					{
						$color	= \Enums\Color::BLACK;
					}
					else // Odd column
					{
						$color	= \Enums\Color::WHITE;
					}
				}
				else // Odd row
				{
					if ($column_counter % 2 == 0) // Even column
					{
						$color	= \Enums\Color::WHITE;
					}
					else // Odd column
					{
						$color	= \Enums\Color::BLACK;
					}
				}
				
				$column_counter++;
				
				$square = new ChessBoardSquare($color);
			
				$this->boardMatrix[$row][$column]	= $square;
			}
		}
		
		// Small but useful for rendering hack -- Since usually, when you draw
		// a chess board table, you are drawing from the top to the bottom. 
		// And since the chances are very high that you will draw the board by simply
		// iterating through the fields, we're going to do the array reverse 
		// over the rows, so array will be ordered from top to bottom (row 8, row 7, row 6, etc.)
		
		$this->boardMatrix	= array_reverse($this->boardMatrix, true);
	}
	
	/**
	 * Returns the ChessBoardSquare found on following coordinates.
	 * 
	 * If you're playing smartass, and enter non-existing column, you'll get FALSE of course ...
	 * 
	 * @param int $row Board row (1 - 8)
	 * @param char $column Column (a - h)
	 * @return \Libs\ChessBoardSquare
	 */
	public function getSquareByCoordinates($row, $column)
	{
		$column	= strtolower($column); // Let's just be sure we're on the same track ;)
		
		if ( ! isset($this->boardMatrix[$row][$column]))
		{
			return false;
		}
		else
		{
			return $this->boardMatrix[$row][$column];
		}
	}
	
	/**
	 * Returns the Board Matrix (2-D Array where first index represents the row
	 * and second index represents the column)
	 * 
	 * @return array
	 */
	public function getBoardMatrix()
	{
		return $this->boardMatrix;
	}
	
	/**
	 * Arranges the chess pieces for the new game
	 */
	public function settleUpPiecesForNewGame()
	{
		//
		// First, set up for White Player
		//
		
		$this->getSquareByCoordinates(1, 'a')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::ROOK, \Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'b')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::KNIGHT, \Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'c')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::BISHOP, \Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'd')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::QUEEN, \Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'e')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::KING, \Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'f')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::BISHOP, \Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'g')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::KNIGHT,\Enums\Color::WHITE));
		$this->getSquareByCoordinates(1, 'h')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::ROOK, \Enums\Color::WHITE));
		
		// Add pawns on row 2
		
		foreach (range('a', 'h') AS $column)
		{
			$this->getSquareByCoordinates(2, $column)->setChessPiece(new ChessPiece(\Enums\ChessPieceType::PAWN, \Enums\Color::WHITE));
		}
		
		
		
		
		
		//
		// Now, set up for black player
		//
		
		$this->getSquareByCoordinates(8, 'a')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::ROOK, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'b')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::KNIGHT, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'c')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::BISHOP, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'd')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::QUEEN, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'e')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::KING, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'f')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::BISHOP, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'g')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::KNIGHT, \Enums\Color::BLACK));
		$this->getSquareByCoordinates(8, 'h')->setChessPiece(new ChessPiece(\Enums\ChessPieceType::ROOK, \Enums\Color::BLACK));
		
		// Add pawns on row 2
		
		foreach (range('a', 'h') AS $column)
		{
			$this->getSquareByCoordinates(7, $column)->setChessPiece(new ChessPiece(\Enums\ChessPieceType::PAWN, \Enums\Color::BLACK));
		}
	}


}
