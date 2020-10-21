<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIntegrante extends Model
{
	protected $fillable = ['microprestamo_id','prestamo_individual','encargado_id','grupo_prestamo_id','estado','destino_inversion_id','dia_pago'];

	public function prestamista(){
		return $this->belongsTo('App\Encargado','encargado_id','id');
	}
	public function grupos(){
		return $this->belongsTo('App\GrupoPrestamo','grupo_prestamo_id','id');
	}
	public function abonos(){
		return $this->belongsTo('App\AbonoPrestamo','abono_prestamo_id','id');
	}
	public function destino(){
		return $this->belongsTo('App\DestinoInversion','destino_inversion_id','id');
	}
	public function microprestamo(){
		return $this->belongsTo('App\Microprestamo','microprestamo_id','id');
	}
	
	public function datos_prestamista(){
		return $this->hasManyThrough(
			'App\PersonaSinAcceso',
			'App\Encargado',
			'id',
			'id',
			'encargado_id',
			'persona_sin_acceso_id'
		);
	}
}
