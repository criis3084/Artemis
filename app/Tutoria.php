<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutoria extends Model
{
	protected $fillable = ['nombre','fecha','estado','tutor_id','nino_id'];

	public function tutor(){
		return $this->belongsTo(Tutoria::class);
	}
	public function nino(){
		return $this->belongsTo(Nino::class);
	}
}
