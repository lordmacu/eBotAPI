<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

class MapScore extends Model
{
	protected $table = 'maps_score';

	protected $fillable = [
		'map_id', 'type_score', 'score1_side1', 'score1_side2', 'score2_side1', 'score2_side2'
	];

	protected $appends = [
		'team_a_score', 'team_b_score', 'score_type'
	];

	const TYPE_NORMAL = 'normal';
	const TYPE_OVERTIME = 'overtime';

	public function map()
	{
		return $this->belongsTo('\Reflex\Database\Models\Map');
	}

	public function getTeamAScoreAttribute()
	{
		return ($this->score1_side1 + $this->score1_side2);
	}

	public function getTeamBScoreAttribute()
	{
		return ($this->score2_side1 + $this->score2_side2);
	}

	public function getScoreTypeAttribute()
	{
		return ($this->type_score == 'normal') ? self::TYPE_NORMAL : self::TYPE_OVERTIME;
	}
}