<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacion extends Model
{
	protected $fillable = ['relacion','direccion','codigo','nino_id','encargado_id','sector_id','estado'];

	public function nino(){
		return $this->belongsTo(Nino::class);
	}
	public function encargado(){
		return $this->belongsTo(Encargado::class);
	}
	public function sector(){
		return $this->belongsTo(Sector::class);
	}
}
