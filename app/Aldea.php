<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aldea extends Model
{
	protected $fillable = ['nombre'];

	public function sectores(){
		return $this->hasMany(Sector::class);
	}
}