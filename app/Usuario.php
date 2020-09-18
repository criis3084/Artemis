<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	protected $fillable = ['nombres','apellidos','CUI','genero','numero_telefono','correo','direccion','fecha_nacimiento','imagen_perfil','descripcion','estado','usuario','password','rol_id'];

	public function rol(){
		return $this->belongsTo('App\Rol','rol_id','id');
	}
}
