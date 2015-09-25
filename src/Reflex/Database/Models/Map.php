<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
use Reflex\Database\Models\MapScore;
use Reflex\Database\Models\Match;

class Map extends Model
{
	protected $table = 'maps';

    protected $fillable = [
    	'match_id', 'map_name', 'score_1', 'score_2', 'current_side',
		'status', 'maps_for', 'nb_ot', 'identifier_id', 'tv_record_file'
	];

	public function match()
	{
		return $this->belongsTo(Match::class);
	}

	public function mapScores()
	{
		return $this->hasMany(MapScore::class);
	}
}