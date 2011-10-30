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
	
	
	public function isMovementAllowed(ChessBoardSquare $fromChessBoardSquare, ChessBoardSquare $toChessBoardSquare)
	{
		// If current player's king is under check, ONLY king can move, and ONLY
		// to fields that aren't under check !
		
		
		
		
		// Empty squares aren't allowed to be moved ;)
		if ( ! $fromChessBoardSquare->getChessPiece())
		{
			return false;
		}
		
		// Check whose turn is it ? If it's white's turn, but we tried playing 
		// with black piece (or vice - versa) -- that is NOT allowed !
		if ($this->getPlayerWhoseTurnIsNow()->getColor() != $fromChessBoardSquare->getChessPiece()->getColor())
		{
			echo "INVALID PLAYER COLOR !!! <br/>";
			
			return false;
		}
		
		
		// This is more than simple operation -- get all possible movements and
		// see if requested one is one of them :-)
		
		$allowedMovements = $this->getAllPossibleMovements($fromChessBoardSquare);
		
		if (empty($allowedMovements))
		{
			return false;
		}
		else
		{
			return $toChessBoardSquare->isContainedIn($allowedMovements);
		}
	}

	
	
	
	/**
	 * Returns array of all ChessBoardSquare objects where piece from target
	 * square can move to
	 * 
	 * If there are no possible movements, empty array will be returned
	 * 
	 * @param ChessBoardSquare $chessBoardSquare 
	 * @return array|ChessBoardSquare
	 */
	public function getAllPossibleMovements(ChessBoardSquare $chessBoardSquare)
	{
		$movements = array();
		
		// If there's no chess piece - no movements are available :-)
		if ( ! $chessBoardSquare || ! $chessBoardSquare->getChessPiece())
		{
			return $movements;
		}
		
		// Delegates would come in handy now heh ....
		switch($chessBoardSquare->getChessPiece()->getType())
		{
			case \Enums\ChessPieceType::BISHOP:
				$movements	= $this->getAllPossibleMovementsForBishop($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::KING:
				$movements	= $this->getAllPossibleMovementsForKing($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::KNIGHT:
				$movements	= $this->getAllPossibleMovementsForKnight($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::PAWN:
				$movements	= $this->getAllPossibleMovementsForPawn($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::QUEEN:
				$movements	= $this->getAllPossibleMovementsForQueen($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::ROOK:
				$movements	= $this->getAllPossibleMovementsForRook($chessBoardSquare);
				break;
		}
		
		return $movements;
	}
	
	/**
	 *
	 * @param ChessBoardSquare $chessBoardSquare 
	 * @return array|ChessBoardSquare
	 */
	public function getAllSquaresUnderAttackByChessPiece(ChessBoardSquare $chessBoardSquare)
	{
		$squares = array();
		
		switch($chessBoardSquare->getChessPiece()->getType())
		{
			case \Enums\ChessPieceType::BISHOP:
				$squares	= $this->getAllPossibleMovementsForBishop($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::KING:
				$squares	= $this->getAllPossibleMovementsForKing($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::KNIGHT:
				$squares	= $this->getAllPossibleMovementsForKnight($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::PAWN:
				$squares	= $this->getAllSquaresUnderAttackByPawn($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::QUEEN:
				$squares	= $this->getAllPossibleMovementsForQueen($chessBoardSquare);
				break;
			
			case \Enums\ChessPieceType::ROOK:
				$squares	= $this->getAllPossibleMovementsForRook($chessBoardSquare);
				break;
		}
		
		return $squares;
		
		
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
		
		$movements = ChessBoardHelper::getAllNeighbourFields($this->getChessGame()->getChessBoard(), $chessBoardSquare);
		
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
		
		$this->removeOutOfRangeMovements($movements);
		
		//
		// Find the location where Opponent's king is located. All locations (squares)
		// around opponent's king are forbidden locations !
		//
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		$opponentKingSquare	= $this->getChessGame()->getChessBoard()->findChessPiece(new ChessPiece(\Enums\ChessPieceType::KING, $opponnentColor));
		
		// All fields around Opponent's king are NO-NO !
		$forbiddenFields	= ChessBoardHelper::getAllNeighbourFields($this->getChessGame()->getChessBoard(), $opponentKingSquare);
		
		$_movements = $movements;
		
		foreach ($_movements AS $key => $destinationField)
		{
			
			// If there is chess piece of the same color on the destination field
			// movement isn't possible !
			
			if ($this->getChessGame()->getChessBoard()->getSquareByLocation($destinationField->getLocation())->getChessPiece())
			{
				unset($movements[$key]);
				
				continue;
			}
			
			// All fields around Opponent's king are NO-NO !
			if ($destinationField->isContainedIn($forbiddenFields))
			{
				unset($movements[$key]);
				
				continue;
			}
			// All fields that are under attack by opponent are NO-NO !
			else if ($this->isSquareUnderAttack($destinationField))
			{
				unset($movements[$key]);
				
				continue;
			}
		
		}
		
		
		return $movements;
	}
	
	/**
	 *
	 * @param ChessBoardSquare $chessBoardSquare
	 * @return type 
	 */
	public function getAllPossibleMovementsForQueen(ChessBoardSquare $chessBoardSquare)
	{
		// Queen moves can move in all horizontal, vertical and diagonal directions
		
		$movements	= array();
		
		$movement_lists = array(
			ChessBoardHelper::getAllDiagonalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare)
			, ChessBoardHelper::getAllVerticalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare)
			, ChessBoardHelper::getAllHorizontalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare)
		);
		
		$movement_lists	= \__::flatten($movement_lists);
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		

		
		// Iterate through movement lists and remove invalid movements
		foreach ($movement_lists AS $key => $linkedList)
		{
			foreach ($linkedList AS $listNode)
			{
				if ( ! $listNode || ! $listNode->data)
				{
					break;
				}
				
				/* @var $destinationField ChessBoardSquare */
				$destinationField = $listNode->data;
				
				// In case that on destination field, we have some chessPiece already:
				//
				//	a) If that's our chessPiece, this movement and all further movements in that direction are forbidden
				//	b) If that's opponent's chessPiece  -- movement is possible, but further ones aren't 
				//	c) If that's opponent's king -- that one and all further are forbidden
				if (($chessPiece = $destinationField->getChessPiece()))
				{
					if ($chessPiece->getColor() == $opponnentColor)
					{
						if ($chessPiece->getType() == \Enums\ChessPieceType::KING)
						{
							break;
						}
						else
						{
							// Movement is possible, but all further aren't
							$movements[]	= $destinationField;
							
							break;
						}
						
					}
					else
					{
						// This seems to be our piece, this movement and all further are forbidden
						break;
					}
				}
				else 
				{
					$movements[]	= $destinationField;
				}
				
			}
		}
		
		
		return $movements;
		
	}
	
	/**
	 *
	 * @todo Implement El-passant move (if I ever figure out how to ...)
	 * @param ChessBoardSquare $chessBoardSquare 
	 */
	public function getAllPossibleMovementsForPawn(ChessBoardSquare $chessBoardSquare)
	{
		// Pawn can move:
		//	a) One field up (unless there's the piece of the same color on that field)
		//	b) One field to the left/right upper diagonal, if there's opponent's piece
		//		on those fields (unless the opponent's piece is KING, in which case,
		//		the movement is NOT possible !)
		//	c) Two fields up if it's pawn's first movement and if previous rules
		//		are respected
		
		$movements = array();
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		// Fix for black player where black player is allowed to go only in negative direction
		if ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
		{
			$sign = 1;
		}
		else
		{
			$sign = -1;
		}
		
		//
		// a) One field up
		//
		
		$destination_field	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + (1 * $sign)
						, $chessBoardSquare->getLocation()->getColumn()
				)
		);
		
		if ($destination_field && ! $destination_field->getChessPiece())
		{
			$movements[]	= $destination_field;
		}
		
		//
		// c) Two fields up
		//
		
		$destination_field	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + (2 * $sign)
						, $chessBoardSquare->getLocation()->getColumn()
				)
		);
		
		if ($destination_field && $chessBoardSquare->getChessPiece()->getTotalMoves() == 0 && ! $destination_field->getChessPiece())
		{
			if ( ! $destination_field->getChessPiece() 
					|| ($destination_field->getChessPiece()->getColor() == $opponnentColor && $destination_field->getChessPiece()->getType() != \Enums\ChessPieceType::KING))
			$movements[]	= $destination_field;
		}
		
		
		
		//
		// b) Diagonal top-left and diagonal top-right if there are opponent's pieces
		//
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		// diagonal top-left
		$destination_field	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + (1 * $sign)
						, chr($columnInt - 1 * $sign)
				)
		);
		
		if ($destination_field && $destination_field->getChessPiece() 
				&& $destination_field->getChessPiece()->getColor() == $opponnentColor
				&& $destination_field->getChessPiece()->getType() != \Enums\ChessPieceType::KING)
		{
			$movements[]	= $destination_field;
		}
		
		
		// diagonal top-right
		$destination_field	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + (1 * $sign)
						, chr($columnInt + 1 * $sign)
				)
		);
		
		if ($destination_field && $destination_field->getChessPiece() 
				&& $destination_field->getChessPiece()->getColor() == $opponnentColor
				&& $destination_field->getChessPiece()->getType() != \Enums\ChessPieceType::KING)
		{
			$movements[]	= $destination_field;
		}
		
		
		return $movements;
	}
	
	/**
	 *
	 * @param ChessBoardSquare $chessBoardSquare 
	 * @return array|ChessBoardSquare
	 */
	public function getAllSquaresUnderAttackByPawn(ChessBoardSquare $chessBoardSquare)
	{
		
		$movements = array();
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		// Fix for black player where black player is allowed to go only in negative direction
		if ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
		{
			$sign = 1;
		}
		else
		{
			$sign = -1;
		}
		
		
		//
		// Pawn attacks diagonal top-left and diagonal top-right fields
		//
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		// diagonal top-left
		$destination_field	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + (1 * $sign)
						, chr($columnInt - 1 * $sign)
				)
		);
		
		if ($destination_field)
		{
			$movements[]	= $destination_field;
		}
		
		
		// diagonal top-right
		$destination_field	= $this->getChessGame()->getChessBoard()->getSquareByLocation(
				new Coordinates(
						$chessBoardSquare->getLocation()->getRow() + (1 * $sign)
						, chr($columnInt + 1 * $sign)
				)
		);
		
		if ($destination_field)
		{
			$movements[]	= $destination_field;
		}
		
		
		return $movements;
	}
	
	public function getAllPossibleMovementsForRook(ChessBoardSquare $chessBoardSquare)
	{
		// Rook can move horizontally and vertically on all possible fields
		
		$movements = array();
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		$movement_lists = array(
			ChessBoardHelper::getAllVerticalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare)
			, ChessBoardHelper::getAllHorizontalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare)
		);
		
		$movement_lists	= \__::flatten($movement_lists);
		
		// Iterate through movement lists and remove invalid movements
		foreach ($movement_lists AS $key => $linkedList)
		{
			foreach ($linkedList AS $listNode)
			{
				if ( ! $listNode || ! $listNode->data)
				{
					break;
				}
				
				/* @var $destinationField ChessBoardSquare */
				$destinationField = $listNode->data;
				
				// In case that on destination field, we have some chessPiece already:
				//
				//	a) If that's our chessPiece, this movement and all further movements in that direction are forbidden
				//	b) If that's opponent's chessPiece  -- movement is possible, but further ones aren't 
				//	c) If that's opponent's king -- that one and all further are forbidden
				if (($chessPiece = $destinationField->getChessPiece()))
				{
					if ($chessPiece->getColor() == $opponnentColor)
					{
						if ($chessPiece->getType() == \Enums\ChessPieceType::KING)
						{
							break;
						}
						else
						{
							// Movement is possible, but all further aren't
							$movements[]	= $destinationField;
							
							break;
						}
						
					}
					else
					{
						// This seems to be our piece, this movement and all further are forbidden
						break;
					}
				}
				else 
				{
					$movements[]	= $destinationField;
				}
				
			}
		}
		
		return $movements;
	}
	
	
	
	public function getAllPossibleMovementsForBishop(ChessBoardSquare $chessBoardSquare)
	{
		// Rook can move diagonally on all possible fields
		
		$movements = array();
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		$movement_lists = array(
			ChessBoardHelper::getAllDiagonalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare)
		);
		
		$movement_lists	= \__::flatten($movement_lists);
		
		// Iterate through movement lists and remove invalid movements
		foreach ($movement_lists AS $key => $linkedList)
		{
			foreach ($linkedList AS $listNode)
			{
				if ( ! $listNode || ! $listNode->data)
				{
					break;
				}
				
				/* @var $destinationField ChessBoardSquare */
				$destinationField = $listNode->data;
				
				// In case that on destination field, we have some chessPiece already:
				//
				//	a) If that's our chessPiece, this movement and all further movements in that direction are forbidden
				//	b) If that's opponent's chessPiece  -- movement is possible, but further ones aren't 
				//	c) If that's opponent's king -- that one and all further are forbidden
				if (($chessPiece = $destinationField->getChessPiece()))
				{
					if ($chessPiece->getColor() == $opponnentColor)
					{
						if ($chessPiece->getType() == \Enums\ChessPieceType::KING)
						{
							break;
						}
						else
						{
							// Movement is possible, but all further aren't
							$movements[]	= $destinationField;
							
							break;
						}
						
					}
					else
					{
						// This seems to be our piece, this movement and all further are forbidden
						break;
					}
				}
				else 
				{
					$movements[]	= $destinationField;
				}
				
			}
		}
		
		return $movements;
	}
	
	
	public function getAllPossibleMovementsForKnight(ChessBoardSquare $chessBoardSquare)
	{
		// Knight can move as follows:
		// a) Two fields left/right
		//	a.1) Then, one field up/down
		// b) Two fields up/down
		//	b.1) Then, one field left/right
		
		$movements = array();
		
		$opponnentColor	= ($chessBoardSquare->getChessPiece()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		// Get all horizontal directions (this would be two arrays - left and right progressions)
		$_horizontal_progressions	= ChessBoardHelper::getAllHorizontalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare);
		
		$horizontal_movements	= array();
		
		foreach ($_horizontal_progressions AS $progression)
		{
			if ($progression)
			{
				$horizontal_movements[]	= $progression->readNode(2);
			}
		}
		
		$_movements_a = array();
		
		foreach ($horizontal_movements AS $horizontal_movement)
		{
			if ( ! $horizontal_movement) // Sometimes, we go out of range :-)
			{
				continue;
			}
			else
			{
				$_movements_a[]	= array(
					$this->getChessGame()->getChessBoard()->getSquareByLocation(new Coordinates(
							$horizontal_movement->getLocation()->getRow() + 1
							, $horizontal_movement->getLocation()->getColumn()
						)
					)
					, $this->getChessGame()->getChessBoard()->getSquareByLocation(new Coordinates(
							$horizontal_movement->getLocation()->getRow() - 1
							, $horizontal_movement->getLocation()->getColumn()
						)
					)
				);
			}
			
		}
		
		$movements[]	= $_movements_a;
		
		
		
		
		
		
		
		
		//
		// Get all vertial directions (this would be two arrays - top and bottom progressions)
		//
		
		$_vertical_progressions	= ChessBoardHelper::getAllVerticalFields($this->getChessGame()->getChessBoard(), $chessBoardSquare);
		
		$vertical_movements	= array();
		
		foreach ($_vertical_progressions AS $progression)
		{
			if ($progression)
			{
				$vertical_movements[]	= $progression->readNode(2);
			}
		}
		
		/* @var $vertical_movements ChessBoardSquare */
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		$_movements_b = array();
		
		foreach ($vertical_movements AS $vertical_movement)
		{
			if ( ! $vertical_movement) // Sometimes, we go out of range :-)
			{
				continue;
			}
			else
			{
				$_movements_b[]	= array(
					$this->getChessGame()->getChessBoard()->getSquareByLocation(new Coordinates(
							$vertical_movement->getLocation()->getRow()
							, chr($columnInt + 1)
						)
					)
					, $this->getChessGame()->getChessBoard()->getSquareByLocation(new Coordinates(
							$vertical_movement->getLocation()->getRow()
							, chr($columnInt - 1)
						)
					)
				);
			}
			
		}
		
		$movements[]	= $_movements_b;
		
		
		
		
		
		$movement_list	= \__::flatten($movements);
		$movements = array();
		
		// Convert each to movement to single linked list
		foreach ($movement_list AS $key => $movement)
		{
			$list = new \LinkList();
			$list->insertLast($movement);
			$movement_list[$key] = $list;
		}
		
		
		// Iterate through movement lists and remove invalid movements
		foreach ($movement_list AS $key => $linkedList)
		{
			foreach ($linkedList AS $listNode)
			{
				if ( ! $listNode || ! $listNode->data)
				{
					break;
				}
				
				/* @var $destinationField ChessBoardSquare */
				$destinationField = $listNode->data;
				
				// In case that on destination field, we have some chessPiece already:
				//
				//	a) If that's our chessPiece, this movement and all further movements in that direction are forbidden
				//	b) If that's opponent's chessPiece  -- movement is possible, but further ones aren't 
				//	c) If that's opponent's king -- that one and all further are forbidden
				if (($chessPiece = $destinationField->getChessPiece()))
				{
					if ($chessPiece->getColor() == $opponnentColor)
					{
						if ($chessPiece->getType() == \Enums\ChessPieceType::KING)
						{
							break;
						}
						else
						{
							// Movement is possible, but all further aren't
							$movements[]	= $destinationField;
							
							break;
						}
						
					}
					else
					{
						// This seems to be our piece, this movement and all further are forbidden
						break;
					}
				}
				else 
				{
					$movements[]	= $destinationField;
				}
				
			}
		}
		
		return $movements;
	}
	
	
	public function removeOutOfRangeMovements(&$movements)
	{
		$_movements = $movements;
		
		foreach ($_movements AS $key => $destinationField)
		{
			// Remove out-of-range movements
			if ( ! $destinationField)
			{
				unset ($movements[$key]);
				
				continue;
			}
		}
	}
	
	/**
	 * Returns the player whose turn to play is now (white/black)
	 * 
	 * @return Player
	 */
	public function getPlayerWhoseTurnIsNow()
	{
		// Even turns (0,2,4,6,...) are for White Player, while odd turns (1,3,5,...)
		// are for black player
		
		$total_movements = $this->getChessGame()->getTotalMovements();
		
		return ($total_movements == 0 || $total_movements % 2 == 0) 
			? $this->getChessGame()->getWhitePlayer()
			: $this->getChessGame()->getBlackPlayer()
		;
	}
	
	/**
	 * Checks if specified square is under attack by opponent
	 * 
	 * @param ChessBoardSquare $chessBoardSquare
	 * @return bool 
	 */
	public function isSquareUnderAttack(ChessBoardSquare $chessBoardSquare)
	{
		$opponnentColor	= ($this->getPlayerWhoseTurnIsNow()->getColor() == \Enums\Color::WHITE)
				? \Enums\Color::BLACK
				: \Enums\Color::WHITE
		;
		
		// First, collect all opponent's pieces
		$opponentsPieces = $this->getChessGame()->getChessBoard()->getAllChessPieces($opponnentColor);
		
		$fieldsUnderAttack = array();
		
		foreach ($opponentsPieces AS $piece)
		{
			$fieldsUnderAttack[]	= $this->getAllSquaresUnderAttackByChessPiece($piece);
		}
		
		$fieldsUnderAttack = \__::flatten($fieldsUnderAttack);
		
		return $chessBoardSquare->isContainedIn($fieldsUnderAttack);
	}
}
