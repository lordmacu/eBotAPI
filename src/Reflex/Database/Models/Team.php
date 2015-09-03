<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

class Team extends Model
{
	protected $table = 'teams';

	protected $fillable = [
		'name', 'shorthandle', 'flag', 'link'
	];

	public function seasons()
	{
		return $this->belongsToMany('\Reflex\Database\Models\Season', 'teams_in_seasons');
	}
}