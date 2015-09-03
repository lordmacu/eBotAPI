<?php

namespace Reflex;

use Reflex\Database\Database;

class eBot
{
	protected $sql_host;
	protected $sql_user;
	protected $sql_pass;
	protected $sql_db;

	protected $db_instance;

	public function __construct($sql_host, $sql_user, $sql_pass, $sql_db)
	{
		$this->sql_host = $sql_host;
		$this->sql_user = $sql_user;
		$this->sql_pass = $sql_pass;
		$this->sql_db = $sql_db;
	}
}