<?php

class Auto_Loader
{

	public static function load($name)
	{
		if (strpos($name, "\\") === false)
		{
//			throw new Exception("AutoLoader can't handle non-namespaced classes ! You must include them manually ! Path: $name");
			return false;
		}

//	$name	= strtolower($name);

		$path = explode("\\", $name);

		$include_path = APP_PATH . "common";

		foreach ($path AS $path)
		{
			$include_path .= "/$path";
		}

		$include_path .= ".php";

		require_once $include_path;

	}

}

