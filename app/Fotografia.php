<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fotografia extends Model
{
	protected $fillable = ['ruta','descripcion','titulo','estado'];
}
