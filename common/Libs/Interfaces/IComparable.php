<?php

namespace Libs\Interfaces;

/**
 * IComparable
 * 
 * Declares that method is comparable versus same objects
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
interface IComparable
{
	public function equal($object);
	
	public function isContainedIn(Array $objects);
}