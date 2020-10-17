<?php

namespace App\Http\Controllers;

use App\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class EscuelaController extends Controller
{

    public function index(Request $request)
    {
		// Filtro por un criterio y estado
        $buscar = $request->buscar;
        $criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Escuela::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$escuela = Escuela::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$escuela = Escuela::where([['estado',1],[$criterio, 'like', $buscar ]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$escuela = Escuela::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$escuela = Escuela::where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if($completo == 'select')
		{
			$escuela = Escuela::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return [
            'escuelas' => $escuela
		];
		
    }

	public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$escuela = new Escuela();
			$escuela->nombre = $request->nombre;
			$escuela->direccion = $request->direccion;
			$escuela->save();
			return Response::json(['message' => 'Escuela Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Escuela $escuela)
    {
		return [
			'id'=> $escuela->id,
			'nombre'=> $escuela->nombre,
			'direccion'=> $escuela->direccion,
			'ninos'=> $escuela->ninos
		];
    }

    public function update(Request $request, Escuela $escuela)
    {
        try {
		$escuela = Escuela::findOrFail($request->id);
		$escuela->nombre = $request->nombre;
		$escuela->direccion = $request->direccion;
		$escuela->save();
		return Response::json(['message' => 'Escuela Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function activar(Escuela $escuela)
	{
		//if(!$request->ajax())return redirect('/');
		$escuela = Escuela::findOrFail($escuela->id);
		$escuela->estado = '1';
		$escuela->save();
		return Response::json(['message' => 'Escuela Activada'], 200);
	}
    public function desactivar(Escuela $escuela)
    {
		//if(!$request->ajax())return redirect('/');
        $escuela = Escuela::findOrFail($escuela->id);
        $escuela->estado = '0';
		$escuela->save();
		return Response::json(['message' => 'Escuela Desactivado'], 200);
    }
}
