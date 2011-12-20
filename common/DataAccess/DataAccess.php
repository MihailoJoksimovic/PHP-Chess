<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace DataAccess;

/**
 * DataAccess
 *
 * @author Mihailo Joksimovic <tinzey@gmail.com>
 */
abstract class DataAccess extends \PDO
{
	
	public function __construct()
	{
			$dsn = 'mysql:dbname=' . MYSQL_DB_NAME . ';host=' . MYSQL_HOST;
			
			parent::__construct($dsn, MYSQL_USERNAME, MYSQL_PASSWORD);
			
			$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
}