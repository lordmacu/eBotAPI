<?php

namespace Reflex\Database\Models;

use Reflex\Database\Model;

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
		return $this->hasMany('\Reflex\Database\Models\Match');
	}

	public function teams()
	{
		return $this->belongsToMany('\Reflex\Database\Models\Team', 'teams_in_seasons');
	}

	public function adverts()
	{
		return $this->hasMany('\Reflex\Database\Models\Advert');
	}
}