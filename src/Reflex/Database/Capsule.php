<?php

namespace Reflex\Database;

use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;

class Capsule
{
	protected $capsule;

	public function __construct()
	{
		$this->capsule = new Manager;
	}

	public function addAndBoot($host, $user, $pass, $db, $prefix = '')
	{
		$this->addConnection($host, $user, $pass, $db, $prefix);
		$this->boot();
	}

	public function addConnection($host, $user, $pass, $db, $prefix = '')
	{
		$this->capsule->addConnection([
			'driver'	=> 'mysql',
			'host'		=> $host,
			'database'	=> $db,
			'username'	=> $user,
			'password'	=> $pass,
			'charset'	=> 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'	=> $prefix
		]);
	}

	public function boot()
	{
		$this->capsule->setEventDispatcher(new Dispatcher(new Container));
		$this->capsule->setAsGlobal();
		$this->capsule->bootEloquent();
	}
}
