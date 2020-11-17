<?php

namespace App\Http\Controllers;

use App\PersonaSinAcceso;
use App\Relacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Type\ObjectType;

class RelacionController extends Controller
{

    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = Relacion::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$relacion = Relacion::with('sector')->with('datos_nino')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$relacion = Relacion::with('sector')->with('datos_nino')->where([[$criterio, 'like', $buscar ],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$relacion = Relacion::with('sector')->with('datos_nino')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$relacion = Relacion::with('sector')->with('datos_nino')->where($criterio, 'like', $buscar )->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if ($completo=='informacion')
		{
			$relacion = Relacion::with('sector')->with('datos_nino')->with('datos_encargado')->with('nino')->with('encargado')->where($criterio, 'like', $buscar )->orderBy('id', 'desc')->paginate($count);
		}
		return [
			"relaciones"=>$relacion
		];
    }

    public function store(Request $request)
    {
		try {
			$relacion = new Relacion();
			$relacion->relacion = $request->relacion;
			$relacion->direccion = $request->direccion;
			$relacion->codigo = $request->codigo;
			$relacion->nino_id = $request->nino_id;
			$relacion->encargado_id = $request->encargado_id;
			$relacion->sector_id = $request->sector_id;
			
			$relacion->estado = $request->estado;
			$relacion->save();
			return ['id' => $relacion->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Request $request)
    {
		try {
			$relacion = new Relacion();
			$relacion->relacion = $request->relacion;
			$relacion->direccion = $request->direccion;
			$relacion->codigo = $request->codigo;
			$relacion->nino_id = $request->nino_id;
			$relacion->encargado_id = $request->encargado_id;
			$relacion->sector_id = $request->sector_id;
			
			$relacion->estado = $request->estado;
			$relacion->save();
			return ['id' => $relacion->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		if (isset($request->tipo)){
			if ($request->tipo =='relacion'){
				$listaEncargado = Relacion::where('encargado_id', $request->encargado_id)->get();
				foreach($listaEncargado as $det)
				{
					$detalle = Relacion::findOrFail($det->id);
					$detalle->relacion = $request->relacion;
					$detalle->save();
				}
			}
			if($request->tipo =='datos'){
				$listaPersonas = $request->personas;
				$listaFamilia = Relacion::where('codigo', $request->codigo)->get();
				foreach($listaFamilia as $det)
				{
					$detalle = Relacion::findOrFail($det->id);
					$detalle->direccion = $request->direccion;
					$detalle->sector_id = $request->sector_id;
					$detalle->save();
				}
				foreach($listaPersonas as $per){
					$editarPersona= PersonaSinAcceso::findOrFail($per);
					$editarPersona->sector_id = $request->sector_id;
					$editarPersona->save();
				}
			}
		}
		return Response::json(['message' => 'Relación Acualizada'], 200);
    }

	public function activar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $relacion = Relacion::findOrFail($request->id);
        $relacion->estado = '1';
        $relacion->save();
		return Response::json(['message' => 'Relacion Desactivada'], 200);
	}
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $relacion = Relacion::findOrFail($request->id);
        $relacion->estado = '0';
        $relacion->save();
		return Response::json(['message' => 'Relacion Desactivada'], 200);
	}
	public function eliminar(Request $request)
    {
		$relacion = Relacion::where('encargado_id', $request->id)->delete();
		return Response::json(['message' => 'Relacion Eliminada'], 200);
	}
}
