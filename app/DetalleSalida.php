<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
	protected $fillable = ['cantidad','salida_medicamento_id','lote_id','estado'];

	public function salidaMedicamento(){
		return $this->belongsTo(SalidaMedicamento::class);
	}
	public function lote(){
		return $this->belongsTo(Lote::class);
	}
}
