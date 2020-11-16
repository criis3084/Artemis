<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoPrestamo extends Model
{
	protected $fillable = ['cantidad_abono','cantidad_restante','descripcion','fecha_pago','mora','detalle_integrante_id','user_id','estado'];


	public function detalle_integrante(){
		return $this->belongsTo('App\DetalleIntegrante','detalle_integrante_id','id');
	}
	public function user(){
		return $this->belongsTo('App\User','user_id','id');
	}
}