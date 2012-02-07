<?php
namespace Libs;

/**
 * GameClock
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class GameClock
{
	/**
	 *
	 * @var Clock
	 */
	private $whitePlayerClock;
	
	/**
	 *
	 * @var Clock
	 */
	private $blackPlayerClock;
	
	public function __construct()
	{
		$this->whitePlayerClock	= new Clock();
		$this->blackPlayerClock	= new Clock();
	}
	
	/**
	 *
	 * @return Clock
	 */
	public function getWhitePlayerClock()
	{
		return $this->whitePlayerClock;

	}

	/**
	 *
	 * @return Clock
	 */
	public function getBlackPlayerClock()
	{
		return $this->blackPlayerClock;

	}
}