<?php

namespace App\Http\Controllers;

use App\Relacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use SebastianBergmann\Type\ObjectType;

class RelacionController extends Controller
{

    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			"relaciones"=>$relacion
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
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
		$relaciones_datos=[];
		$relaciones = Relacion::all();
		$temporal= (Object)['nombre_nino'=>'','nombre_encargado'=>''];
		foreach ($relaciones as $relacion)
		{
			$dato = new Relacion($relacion->id);
			$nombre_nino=$relacion->nino->datos->nombres;
			$nombre_Encargado=$relacion->encargado->datos->nombres;
			$relaciones_datos= array_push($relaciones_datos,['nombre_nino'=>$nombre_nino],['nombre_encargado'=>$nombre_Encargado]);
		}
        return [
			$relaciones_datos
		];
    }

    public function update(Request $request, Relacion $relacion)
    {
		//if(!$request->ajax())return redirect('/');
		$relacion = Relacion::findOrFail($request->id);
		$relacion->relacion = $request->relacion;
		$relacion->direccion = $request->direccion;
		$relacion->codigo = $request->codigo;
		// Actualizar direccion del ni;o del encargado
		// Pendiente
		$relacion->save();
		
		return Response::json(['message' => 'Relazion Acualizada'], 200);
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
}
