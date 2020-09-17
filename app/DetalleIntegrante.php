<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIntegrante extends Model
{
	protected $fillable = ['encargado_id','grupo_prestamo_id','estado'];

	public function prestamista(){
		return $this->belongsTo(Encargado::class);
	}
	public function grupo(){
		return $this->belongsTo(GrupoPrestamo::class);
	}
	public function abonos(){
		return $this->hasMany(AbonoPrestamo::class);
	}
}
