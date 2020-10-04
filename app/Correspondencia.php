<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Correspondencia extends Model
{
	protected $fillable = ['mensaje','encabezado','piePagina','estado'];
}
