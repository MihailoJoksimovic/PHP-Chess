<?php

namespace Libs;

define("UCI_MAX_THINK_TIME", 15);

/**
 * UCI
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
class UCI
{
	private $resorce;
	
	private $pipes;
	
	private $skill	= 10;
	
	private static $instance;
	
	/**
	 * 
	 * @return UCI
	 */
	public static function get()
	{
		if ( ! self::$instance)
		{
			self::$instance = new UCI();
		}
		
		return self::$instance;
	}
	
	public function __construct()
	{
		$this->resorce	= null;
		
		$this->startGame();
	}
	
	protected function startGame()
	{
		if ( ! $this->resorce)
		{
			$descriptorspec = array(
			   0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
			   1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
			   2 => array("file", "/tmp/" . uniqid("uci_"), "a") // stderr is a file to write to
			);

			$cwd = '/tmp';
			
			$env = array();

			$this->resorce = proc_open('nice -n 20 /usr/local/bin/stockfish', $descriptorspec, $this->pipes, $cwd, $env);
		}
		
		if ( ! is_resource($this->resorce))
		{
			$this->shutDown();
			
			throw new \Exception("Resource unavailable !");
		}
		else
		{
			return true;
		}
	}
	
	public function setSkillLevel($level)
	{
		$this->skill	= (int) $level;
	}
	
	/**
	 *
	 * @param array $moves Algebraic notation moves
	 * @param array Assoc. array of additional properties to pass to "go" function
	 *	(e.g. wtime => 50000)
	 */
	public function getBestMove(Array $moves, Array $properties = array())
	{
		$moves	= implode(" ", $moves);
		
		if ( ! is_resource($this->resorce))
		{
			$this->startGame();
		}
		
		// $pipes now looks like this:
		// 0 => writeable handle connected to child stdin
		// 1 => readable handle connected to child stdout
		// Any error output will be appended to /tmp/error-output.txt


		fwrite($this->pipes[0], "uci\n");
		fwrite($this->pipes[0], "ucinewgame\n");
		fwrite($this->pipes[0], "setoption name Skill Level value {$this->skill}\n");
		fwrite($this->pipes[0], "isready\n");
		usleep(500);

		if (empty($moves))
		{
			fwrite($this->pipes[0], "position startpos \n");
		}
		else
		{
			fwrite($this->pipes[0], "position startpos moves $moves \n");
		}
		
		$go_modifiers = "";
		
		if ( ! empty($properties))
		{
			foreach ($properties AS $name => $value)
			{
				$go_modifiers .= "$name $value ";
			}
		}
		
//		if ( ! isset($properties['movetime']))
//		{
//			$go_modifiers	.= "movetime 4000 ";
//		}
		
		fwrite($this->pipes[0], "go $go_modifiers \n");
		fclose($this->pipes[0]);
		
		$start_thinking_time	= time();
		
		while (true)
		{
			
			$return = stream_get_contents($this->pipes[1]);
			
//			echo "$return <br/>";
			
			if (preg_match("/bestmove\s(?P<bestmove>[a-h]\d[a-h]\d)(\sponder\s(?P<ponder>[a-h]\d[a-h]\d))?/i", $return, $matches))
			{
				break;
			}
			elseif (preg_match("/bestmove\s\(none\)/i", $return))
			{
				$this->shutDown();
				
				return null;
			}
			else if ((time() - $start_thinking_time) > UCI_MAX_THINK_TIME)
			{
				$this->shutDown();
				
				\d("UCI says: $return");
				
				throw new \Exception("UCI didn't respond after time limit ! Halting !");
			}
			else
			{
				usleep(50);
				
				continue;
			}
		}
		
		$this->shutDown();
		
		return $matches;
		
	}
	
	public function __destruct()
	{
		$this->shutDown();
	}
	
	protected function shutDown()
	{
		@fclose($this->pipes[0]);
		@fclose($this->pipes[1]);
		@fclose($this->pipes[2]);
		@fclose($this->resorce);
	}
}