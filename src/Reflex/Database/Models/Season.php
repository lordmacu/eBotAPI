<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
use Reflex\Database\Models\Advert;
use Reflex\Database\Models\Match;
use Reflex\Database\Models\Team;

class Season extends Model
{
	protected $table = 'seasons';

	protected $fillable = [
		'name', 'event', 'start', 'end', 'link', 'logo', 'active'
	];

	protected $dates = [
		'start', 'end'
	];

	public function matches()
	{
		return $this->hasMany(Match::class);
	}

	public function teams()
	{
		return $this->belongsToMany(Team::class, 'teams_in_seasons', 'season_id', 'team_id');
	}

	public function adverts()
	{
		return $this->hasMany(Advert::class);
	}
}