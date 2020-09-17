<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
	protected $fillable = ['descripcion_puesto','usuario_id','estado'];

	public function informacion(){
		return $this->belongsTo(Usuario::class);
	}
}
