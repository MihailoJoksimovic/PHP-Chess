<?php

namespace Libs;

class Player
{
	private $id;
	
	private $name;
	
	private $color;
	
	public function __construct($color)
	{
		$this->setColor($color);
	}
	
	public function getId()
	{
		return $this->id;

	}

	public function setId($id)
	{
		$this->id = $id;

	}

	public function getName()
	{
		return $this->name;

	}

	public function setName($name)
	{
		$this->name = $name;

	}

	public function getColor()
	{
		return $this->color;

	}

	public function setColor($color)
	{
		$this->color = $color;

	}


}


