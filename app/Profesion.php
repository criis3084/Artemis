<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
	protected $fillable = ['nombre','estado'];

	public function personalClinico(){
		return $this->hasMany(Clinico::class);
	}
}
