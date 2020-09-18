<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
	protected $fillable = ['descripcion','resultado','fecha_examen','tipo_examen_id','clinico_id','estado'];

	public function tipoExamen(){
		return $this->belongsTo('App\TipoExamen','tipo_examen_id','id');
	}
	public function laboratorista(){
		return $this->belongsTo('App\Clinico','clinico_id','id');
	}
}
