<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

class Advert extends Model
{
	protected $table = 'advertising';

	protected $fillable = [
		'season_id', 'message', 'active'
	];

	public function season()
	{
		return $this->belongsTo('\Reflex\Database\Models\Season');
	}
}