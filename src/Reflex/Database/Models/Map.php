<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

class Map extends Model
{
	protected $table = 'maps';

    protected $fillable = [
    	'match_id', 'map_name', 'score_1', 'score_2', 'current_side',
		'status', 'maps_for', 'nb_ot', 'identifier_id', 'tv_record_file'
	];

	public function match()
	{
		return $this->belongsTo('\Reflex\Database\Models\Match');
	}

	public function mapScores()
	{
		return $this->hasMany('\Reflex\Database\Models\MapScore');
	}
}