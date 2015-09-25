<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;
use Reflex\Database\Models\Season;

class Advert extends Model
{
	protected $table = 'advertising';

	protected $fillable = [
		'season_id', 'message', 'active'
	];

	public function season()
	{
		return $this->belongsTo(Season::class);
	}
}