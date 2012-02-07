<?php

namespace Libs;

/**
 * GameExporter
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class GameExporter
{
	public static function getAlgebraicNotation(ChessGame $game)
	{
		$move_array = array();
		
		foreach ($game->getAllMovements() AS $movement)
		{
			/* @var $movement Movement */
			if ($movement->isSpecialMove())
			{
				if ($movement->getSpecialMove() == 'castle-kingSide')
				{
					if ($movement->getFrom()->getLocation()->getRow() == 1)
					{
						$move_array[] = "e1g1";
					}
					else
					{
						$move_array[]	= "e8g8";
					}
				}
				elseif($movement->getSpecialMove() == 'castle-queenSide')
				{
					if ($movement->getFrom()->getLocation()->getRow() == 1)
					{
						$move_array[] = "e1c1";
					}
					else
					{
						$move_array[]	= "e8c8";
					}
				}
			}
			else
			{
				/* @var $movement \Libs\Movement */
				$move_array[]	= $movement->getFrom()->getLocation()->getColumn() . $movement->getFrom()->getLocation()->getRow()
					 . $movement->getTo()->getLocation()->getColumn() . $movement->getTo()->getLocation()->getRow()
				;
			}
		}
		
		return $move_array;
	}
}