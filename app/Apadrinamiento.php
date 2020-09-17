<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apadrinamiento extends Model
{
	protected $fillable = ['nino_id','padrino_id','estado'];

	public function nino(){
		return $this->belongsTo(Nino::class);
	}
	public function padrino(){
		return $this->belongsTo(Padrino::class);
	}
}
