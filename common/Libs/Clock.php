<?php

namespace Libs;

/**
 * Clock
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class Clock
{
	private $timestampStarted;
	
	private $totalTime;
	
	public function __construct($totalTime)
	{
		$this->totalTime	= $totalTime;
	}
	
	public function startCounting()
	{
		$this->timestampStarted	= time();
	}
	
	public function stopCounting()
	{
		$timeDiff	= (time() - $this->timestampStarted);
		
		$this->totalTime	-= $timeDiff;
	}
	
	public function getTimeLeft()
	{
		return $this->totalTime;
	}
	
}