<?php

/** 
* Title: Single linked list
* Description: Implementation of a single linked list in PHP 
* @author Sameer Borate | codediesel.com
* @version 1.0 20th June 2008
*/

class ListNode
{
    /* Data to hold */
    public $data;
    
    /* Link to next node */
    public $next;
    
    
    /* Node constructor */
    function __construct($data)
    {
        $this->data = $data;
        $this->next = NULL;
    }
    
    function readNode()
    {
        return $this->data;
    }
}


class LinkList implements Iterator
{
    /* Link to the first node in the list */
    private $firstNode;
    
    /* Link to the last node in the list */
    private $lastNode;
    
    /* Total nodes in the list */
    private $count;
	
	private $iteratorPosition	= 0;
    
    
    
    /* List constructor */
    function __construct()
    {
        $this->firstNode = NULL;
        $this->lastNode = NULL;
        $this->count = 0;
    }

    public function isEmpty()
    {
        return ($this->firstNode == NULL);
    }
    
    public function insertFirst($data)
    {
        $link = new ListNode($data);
        $link->next = $this->firstNode;
        $this->firstNode = &$link;
        
        /* If this is the first node inserted in the list
           then set the lastNode pointer to it.
        */
        if($this->lastNode == NULL)
            $this->lastNode = &$link;
            
        $this->count++;
    }
    
    public function insertLast($data)
    {
        if($this->firstNode != NULL)
        {
            $link = new ListNode($data);
            $this->lastNode->next = $link;
            $link->next = NULL;
            $this->lastNode = &$link;
            $this->count++;
        }
        else
        {
            $this->insertFirst($data);
        }
    }
	
	/**
	 *
	 * @return ListNode
	 */
	public function getFirstNode()
	{
		return $this->firstNode;
	}
    
    public function deleteFirstNode()
    {
        $temp = $this->firstNode;
        $this->firstNode = $this->firstNode->next;
        if($this->firstNode != NULL)
            $this->count--;
            
        return $temp;
    }
    
    public function deleteLastNode()
    {
        if($this->firstNode != NULL)
        {
            if($this->firstNode->next == NULL)
            {
                $this->firstNode = NULL;
                $this->count--;
            }
            else
            {
                $previousNode = $this->firstNode;
                $currentNode = $this->firstNode->next;
                
                while($currentNode->next != NULL)
                {
                    $previousNode = $currentNode;
                    $currentNode = $currentNode->next;
                }
                
                $previousNode->next = NULL;
                $this->count--;
            }
        }
    }
    
    public function deleteNode($key)
    {
        $current = $this->firstNode;
        $previous = $this->firstNode;
        
        while($current->data != $key)
        {
            if($current->next == NULL)
                return NULL;
            else
            {
                $previous = $current;
                $current = $current->next;
            }
        }
        
        if($current == $this->firstNode)
            $this->firstNode = $this->firstNode->next;
        else
            $previous->next = $current->next;
            
        $this->count--;   
    }
    
    public function find($key)
    {
        $current = $this->firstNode;
        while($current->data != $key)
        {
            if($current->next == NULL)
                return null;
            else
                $current = $current->next;
        }
        return $current;
    }
    
    public function readNode($nodePos)
    {
        if($nodePos <= $this->count)
        {
            $current = $this->firstNode;
            $pos = 1;
            while($pos != $nodePos)
            {
                if($current->next == NULL)
                    return null;
                else
                    $current = $current->next;
                    
                $pos++;
            }
            return $current->data;
        }
        else
            return NULL;
    }
    
    public function totalNodes()
    {
        return $this->count;
    }
    
    public function readList()
    {
        $listData = array();
        $current = $this->firstNode;
        
        while($current != NULL)
        {
            array_push($listData, $current->readNode());
            $current = $current->next;
        }
        return $listData;
    }
    
    public function reverseList()
    {
        if($this->firstNode != NULL)
        {
            if($this->firstNode->next != NULL)
            {
                $current = $this->firstNode;
                $new = NULL;
                
                while ($current != NULL)
                {
                    $temp = $current->next;
                    $current->next = $new;
                    $new = $current;
                    $current = $temp;
                }
                $this->firstNode = $new;
            }
        }
    }
	
	
	////////// ITERATOR RELATED /////////////////
	
	public function current()
	{
		if ($this->iteratorPosition == 0)
		{
			return $this->firstNode;
		}
		else
		{
			$i = 0;
			
			$current = $this->firstNode;
			
			while ($i++ < $this->iteratorPosition)
			{
				if ( ! $current->next)
				{
					return null;
				}
				else
				{
					$current	= $current->next;
				}
			}
			
			return $current;
		}
		
	}

	public function key()
	{
		return $this->iteratorPosition;
	}

	public function next()
	{
		$this->iteratorPosition++;
		
		$i = 0;
			
		$current = $this->firstNode;

		while ($i++ < $this->iteratorPosition)
		{
			if ( ! $current->next)
			{
				return null;
			}
			else
			{
				$current	= $current->next;
			}
		}
		
		return $current;
	}

	public function rewind()
	{
		$this->iteratorPosition = 0;
	}

	public function valid()
	{
		$i = 0;
			
		$current = $this->firstNode;

		while ($i++ < $this->iteratorPosition)
		{
			if ( ! $current->next)
			{
				return null;
			}
			else
			{
				$current	= $current->next;
			}
		}
		
		return $current;
	}

}

class LinkListCollection implements Iterator
{
	/**
	 * Array of linked lists currently existing in collection
	 * 
	 * @var array
	 */
	private $linkedLists;
	
	///////// 
	// Iterator related values
	/////////
	
	private $currentItem = false;
	
	public function __construct($linkedLists = null)
	{
		if ( ! empty($linkedLists))
		{
			$this->linkedLists = $linkedLists;
		}
	}
	
	public function current()
	{
		
	}

	public function key()
	{
		
	}

	public function next()
	{
		
	}

	public function rewind()
	{
		
	}

	public function valid()
	{
		
	}

}
