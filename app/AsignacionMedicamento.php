<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignacionMedicamento extends Model
{
	protected $fillable = ['cantidad','frecuencia','medicamento_id','receta_id'];

	public function medicamento(){
		return $this->belongsTo('App\Medicamento','medicamento_id','id');
	}
	public function receta(){
		return $this->belongsTo('App\Receta','receta_id','id');
	}
}
