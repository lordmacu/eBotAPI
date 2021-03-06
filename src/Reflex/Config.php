<?php

namespace Reflex;

use Dotenv\Dotenv;
use Reflex\Exceptions\IPNotSetException;

class Config
{
	public static function loadEnv($dir, $file = '.env')
	{
		try {
			$dotenv = new Dotenv($dir, $file);

			$dotenv->required([
				'EBOT_IP',
				'EBOT_PORT'
			]);
			$dotenv->load();
		} catch (\RuntimeException $e) {
			throw new IPNotSetException($e->getMessage());
		}
	}
}