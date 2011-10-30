<?php

namespace Libs;


/**
 * Coordinates
 * 
 * Simple class that encapsulates Row & Column coordinates
 * 
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class Coordinates implements \Libs\Interfaces\IComparable
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
	
	/**
	 * Check if two objects are equal
	 * 
	 * @param Coordinates $object
	 * @return bool
	 */
	public function equal($object)
	{
		return ($object->getRow() == $this->getRow() && $object->getColumn() == $this->getColumn());
	}

	/**
	 * Check if current object is contained in array of provided objects
	 * 
	 * @param array $objects
	 * @return bool 
	 */
	public function isContainedIn(array $objects)
	{
		foreach ($objects AS $object)
		{
			if ($object->equal($this))
			{
				true;
			}
		}
		
		return false;
	}



}