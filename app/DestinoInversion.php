<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinoInversion extends Model
{
	protected $fillable = ['nombre','estado'];

	public function microprestamos(){
		return $this->hasMany(Microprestamo::class);
	}
}
