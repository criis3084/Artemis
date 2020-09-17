<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
	protected $fillable = ['nombre','persona_sin_acceso_id','estado'];

	public function informacion(){
		return $this->belongsTo(PersonaSinAcceso::class);
	}
}
