<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialClinico extends Model
{
	protected $fillable = ['fecha_consulta','descripcion','peso_actual','glicemia','semanas_embarazo','talla','pulso','respiracion','temperatura','presion_arterial','objetivo','subjetivo','paciente_id','clinico_id','estado'];

	public function clinico(){
		return $this->belongsTo('App\Clinico','clinico_id','id');
	}
	public function paciente(){
		return $this->belongsTo('App\Paciente','paciente_id','id');
	}
	public function receta(){
		return $this->hasMany('App\Receta','historial_clinico_id','id');
	}
	public function doctor(){
		return $this->hasManyThrough(
			'App\User',
			'App\clinico',
			'id',
			'id',
			'clinico_id',
			'user_id'
		);
	}
}
