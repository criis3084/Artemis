<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
	protected $fillable = ['nombre','estado'];

	public function usuarios(){
		return $this->hasMany('App\Usuario','rol_id','id');
	}
}
