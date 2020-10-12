<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIntegrante extends Model
{
	protected $fillable = ['prestamo_individual','encargado_id','grupo_prestamo_id','estado','destino_inversion_id'];

	public function prestamista(){
		return $this->belongsTo('App\Encargado','encargado_id','id');
	}
	public function grupo(){
		return $this->belongsTo('App\GrupoPrestamo','grupo_prestamo_id','id');
	}
	public function abonos(){
		return $this->belongsTo('App\AbonoPrestamo','abono_prestamo_id','id');
	}
	public function destino(){
		return $this->belongsTo('App\DestinoInversion','destino_inversion_id','id');
	}
}
