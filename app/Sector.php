<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
	protected $fillable = ['nombre','aldea_id'];

	public function aldea(){
		return $this->belongsTo('App\Aldea','aldea_id','id');
	}
	public function relaciones(){
		return $this->hasMany('App\Relacion','sector_id','id');
	}
	public function personas(){
		return $this->hasMany('App\PersonaSinAcceso','sector_id','id');
	}
}
