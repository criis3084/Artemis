<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
	protected $fillable = ['listado','historial_clinico_id'];

	public function historial(){
		return $this->belongsTo(HistorialClinico::class);
	}
	public function detalleReceta(){
		return $this->hasMany(AsignacionMedicamento::class);
	}
}
