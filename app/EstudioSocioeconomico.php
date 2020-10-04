<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstudioSocioeconomico extends Model
{
    Protected $fillable = ['fecha_boleta','fecha_ingreso','total_ingresos','alimentacion','situacion_vivienda','costo_vivienda','luz','agua','drenaje','cantidad_cuartos','bano','paredes','techo','piso','evaluacion_diagnostico','estado'];
}
