<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignacionMedicamento extends Model
{
	protected $fillable = ['cantidad','frecuencia','medicamento_id','receta_id'];

	public function medicamento(){
		return $this->belongsTo(Medicamento::class);
	}
	public function receta(){
		return $this->belongsTo(Receta::class);
	}
}
