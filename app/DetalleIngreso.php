<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
	protected $fillable = ['cantidad','ingreso_medicamento_id','lote_id','estado'];

	public function ingresoMedicamento(){
		return $this->belongsTo(IngresoMedicamento::class);
	}
	public function lote(){
		return $this->belongsTo(Lote::class);
	}
}
