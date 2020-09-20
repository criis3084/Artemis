<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aldea extends Model
{
	protected $fillable = ['nombre','estado'];

	public function sectores(){
		return $this->hasMany('App\Sector','aldea_id','id');
	}
}