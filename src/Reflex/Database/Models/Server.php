<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

class Server extends Model
{
	protected $table = 'servers';

	protected $fillable = [
		'ip', 'rcon', 'hostname', 'tv_ip'
	];

	public function matches()
	{
		return $this->hasMany('\Reflex\Database\Models\Match');
	}
}