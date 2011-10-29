<?php

namespace Libs;

/**
 * ChessBoardHelper
 * 
 * Contains useful methods for dealing with chessboard
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class ChessBoardHelper
{
	/**
	 * Returns all fields around the given field
	 * 
	 * @return array|ChessBoardSquare
	 */
	public static function getAllNeighbourFields(ChessBoard $chessBoard, ChessBoardSquare $chessBoardSquare)
	{
		$return = array();
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow() + 1, chr($columnInt + 1)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow() + 1, chr($columnInt - 1)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow() - 1, chr($columnInt + 1)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow() - 1, chr($columnInt - 1)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow(), chr($columnInt + 1)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow(), chr($columnInt - 1)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow() - 1, chr($columnInt)
			)
		);
		
		$return[]	= $chessBoard->getSquareByLocation(new Coordinates(
				$chessBoardSquare->getLocation()->getRow() + 1, chr($columnInt)
			)
		);
		
		
		// Remove out-of-range fields
		
		$_return = $return;
		
		foreach ($_return AS $key => $square)
		{
			if ( ! $square)
			{
				unset($return[$key]);
			}
		}
		
		return $return;
	}
	
	
	
	
	
	/**
	 * Returns all horizontal fields in a row around specified square
	 * 
	 * @return array|ChessBoardSquare
	 */
	public static function getAllHorizontalFields(ChessBoard $chessBoard, ChessBoardSquare $chessBoardSquare)
	{
		$return = array();
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		$left_progress = new \LinkList();
		$right_progress	= new \LinkList();
		
		foreach (range(1, 8) AS $i)
		{
			$left = $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow()
					, chr($columnInt - $i)
				)
			);
			
			$left_progress->insertLast($left);
			
			$right = $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow()
					, chr($columnInt + $i)
				)
			);
			
			$right_progress->insertLast($right);
		}
		
		$return = array($left_progress, $right_progress);
		
		// Remove out-of-range fields
		foreach ($return AS $key => $linkedList)
		{	
			for ($i = 0; $i < 8; $i++)
			{
				$linkedList->deleteNode(false);
			}
			
			if (! $linkedList->getFirstNode() ||  $linkedList->getFirstNode()->data === false)
			{
				unset($return[$key]);
			}
		}
		
		return $return;
	}
	
	/**
	 * Returns all vertical fields in a line with specified square
	 * 
	 * @return array|ChessBoardSquare
	 */
	public static function getAllVerticalFields(ChessBoard $chessBoard, ChessBoardSquare $chessBoardSquare)
	{
		$return = array();
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		$vertical_top_progress = new \LinkList();
		$vertical_bottom_progress	= new \LinkList();
		
		foreach (range(1, 8) AS $i)
		{
			$vertical_top = $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow() + $i
					, chr($columnInt)
				)
			);
			
			$vertical_top_progress->insertLast($vertical_top);
			
			$vertical_bottom = $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow() - $i
					, chr($columnInt)
				)
			);
			
			$vertical_bottom_progress->insertLast($vertical_bottom);
		}
		
		$return = array($vertical_top_progress, $vertical_bottom_progress);
		
		// Remove out-of-range fields
		foreach ($return AS $key => $linkedList)
		{	
			for ($i = 0; $i < 8; $i++)
			{
				$linkedList->deleteNode(false);
			}
			
			if (! $linkedList->getFirstNode() ||  $linkedList->getFirstNode()->data === false)
			{
				unset($return[$key]);
			}
		}
		
		return $return;
	}
	
	/**
	 * Returns all diagonal fields in a line with specified square
	 * 
	 * @return array|ChessBoardSquare
	 */
	public static function getAllDiagonalFields(ChessBoard $chessBoard, ChessBoardSquare $chessBoardSquare)
	{
		$return = array();
		
		$columnInt	= ord($chessBoardSquare->getLocation()->getColumn());
		
		
		$top_right_progress = new \LinkList();
		$top_left_progress	= new \LinkList();
		$bottom_left_progress	= new \LinkList();
		$bottom_right_progress	= new \LinkList();
		
		foreach (range(1,8) AS $i)
		{
			
			$top_right = $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow() + $i
					, chr($columnInt + $i)
				)
			);
			
			$top_right_progress->insertLast($top_right);
			
			
			// Progress to bottom left
			$bottom_left	= $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow() - $i
					, chr($columnInt - $i)
				)
			);
			
			$bottom_left_progress->insertLast($bottom_left);
			
			// Progress to top left
			$top_left	= $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow() + $i
					, chr($columnInt - $i)
				)
			);
			
			$top_left_progress->insertLast($top_left);
			
			// Progress to bottom right
			$bottom_right	= $chessBoard->getSquareByLocation(new Coordinates(
					$chessBoardSquare->getLocation()->getRow() - $i
					, chr($columnInt + $i)
				)
			);
			
			$bottom_right_progress->insertLast($bottom_right);
		}
		
		$return = array($top_left_progress, $top_right_progress, $bottom_left_progress, $bottom_right_progress);
		
		// Remove out-of-range fields

//		foreach (\__::compact($return) AS $key => $linkedList)
		foreach ($return AS $key => $linkedList)
		{	
			for ($i = 0; $i < 8; $i++)
			{
				$linkedList->deleteNode(false);
			}
			
			if (! $linkedList->getFirstNode() ||  $linkedList->getFirstNode()->data === false)
			{
				unset($return[$key]);
			}
		}
		
		return $return;
	}
}