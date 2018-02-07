<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
use Reflex\Database\Models\Match;

class Server extends Model
{
	protected $table = 'servers';

	protected $fillable = [
		'ip', 'rcon', 'hostname', 'tv_ip'
	];

	public function matches()
	{
		return $this->hasMany(Match::class);
	}

	public function getServerByIp( $server_ip )
	{
		return $this->where('ip', $server_ip)->first()->id;
	}
}