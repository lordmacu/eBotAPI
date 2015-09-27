<?php

namespace Reflex\Database;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	protected $connection;

	public function __construct(array $attributes = [])
	{
		$this->connection = config('ebot-reflex.connection');

		parent::__construct($attributes);
	}
}