<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialFotografia extends Model
{
	protected $fillable = ['nino_id','fotografia_id','estado'];

	public function nino(){
		return $this->belongsTo(Nino::class);
	}
	public function fotografia(){
		return $this->belongsTo(Fotografia::class);
	}
}
