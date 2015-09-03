<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

class Player extends Model
{
	protected $table = 'players';

	protected $fillable = [
		'match_id', 'map_id', 'player_key', 'team', 'ip', 'steamid', 'first_side', 'current_side',
		'pseudo', 'nb_kill', 'assist', 'death', 'point', 'hs', 'defuse', 'bombe', 'tk', 'nb1',
		'nb2', 'nb3', 'nb4', 'nb5', 'nb1kill', 'nb2kill', 'nb3kill', 'nb4kill', 'nb5kill', 'pluskill',
		'firstkill'
	];

	protected $appends = [
		'team'
	];

	public function match()
	{
		return $this->belongsTo('\Reflex\Database\Models\Match');
	}

	public function map()
	{
		return $this->belongsTo('\Reflex\Database\Models\Map');
	}

	public function getTeamAttribute()
	{
		if($this->attributes['team'] == 'a') {
			return $this->match->teamA;
		} else {
			return $this->match->teamB;
		}
	}
}