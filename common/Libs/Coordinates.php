<?php

namespace Libs;


/**
 * Coordinates
 * 
 * Simple class that encapsulates Row & Column coordinates
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class Coordinates
{
	private $row;
	
	private $column;
	
	public function __construct($row = null, $column = null)
	{
		$this->setRow($row);
		$this->setColumn($column);
	}
	
	public function getRow()
	{
		return $this->row;

	}

	public function setRow($row)
	{
		if ( ! is_null($row))
		{
			if (in_array($row, range(1, 8)))
			{
				$this->row = $row;
			}
			else
			{
				throw new \Exception("Invalid row specified: $row; Valid rows are from 1 to 8", 0);
			}
		}
		else
		{
			$this->row = null;
		}
	}

	public function getColumn()
	{
		return $this->column;

	}

	public function setColumn($column)
	{
		if ( ! is_null($column))
		{
			$column	= strtolower($column);
			
			if (in_array($column, range('a', 'h')))
			{
				$this->column = $column;
			}
			else
			{
				throw new \Exception("Invalid column specified: $column; Valid columns are A - H", 0);
			}
		}
	}


}