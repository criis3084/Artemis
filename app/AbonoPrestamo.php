<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbonoPrestamo extends Model
{
	protected $fillable = ['cantidad_abono','cantidad_restante','descripcion','fecha_pago','mora','microprestamo_id','detalle_integrante_id','usuario_id','estado'];

	public function microprestamo(){
		return $this->belongsTo(Microprestamo::class);
	}
	public function detalle_integrante(){
		return $this->belongsTo(DetalleIntegrante::class);
	}
	public function usuario(){
		return $this->belongsTo(Usuario::class);
	}
}