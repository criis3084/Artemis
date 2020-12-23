<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
	protected $fillable = ['descripcion','resultado','fecha_examen','tipo_examen_id','clinico_id','estado','ruta_imagen'];

	public function tipoExamen(){
		return $this->belongsTo('App\TipoExamen','tipo_examen_id','id');
	}
	public function laboratorista(){
		return $this->belongsTo('App\Clinico','clinico_id','id');
	}
	public function datos_laboratorista(){
		return $this->hasManyThrough(
			'App\User',
			'App\Clinico',
			'id',
			'id',
			'clinico_id',
			'user_id'
		);
	}
}
