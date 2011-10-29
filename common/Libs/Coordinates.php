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
			$this->row	= $row;
		}
		else
		{
			$this->row	= null;
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
			$this->column	= strtolower($column);
		}
		else
		{
			$this->column	= null;
		}
	}
	
	
	public function __toString()
	{
		return "({$this->row}, {$this->column})";
	}


}