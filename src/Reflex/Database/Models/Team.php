<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
use Reflex\Database\Models\Season;

class Team extends Model
{
	protected $table = 'teams';

	protected $fillable = [
		'name', 'shorthandle', 'flag', 'link'
	];

	public function seasons()
	{
		return $this->belongsToMany(Season::class, 'teams_in_seasons');
	}
}