<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
	protected $fillable = ['nombre','estado'];

	public function usuarios(){
		return $this->hasMany(Usuario::class);
	}
}
