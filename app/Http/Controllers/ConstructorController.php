<?php

namespace App\Http\Controllers;

use App\Constructor;
use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ConstructorController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		
		if ($completo == 'false')
		{
			$count = Constructor::where('estado',1)->count();
			if ($buscar==''){
				$constructor = Constructor::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$constructor = Constructor::with('datos')->where([[$criterio, 'like', $buscar ],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = Constructor::all()->count();
			if ($buscar==''){
				$constructor = Constructor::with('datos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$constructor = Constructor::with('datos')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate(1);
			}
		}else if($completo == 'datosAnidados')
		{
			$constructor = Constructor::with('datos')->with('construcciones')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate(1);
		}
		return [
			"constructors"=>$constructor
		];
	}

	public function store(Request $request)
	{
		try {
			$persona = new PersonaSinAcceso();
			$persona->nombres = $request->nombres;
			$persona->apellidos = $request->apellidos;
			$persona->CUI = $request->CUI;
			$persona->numero_telefono = $request->numero_telefono;
			$persona->genero = $request->genero;
			$persona->fecha_nacimiento = $request->fecha_nacimiento;
			$persona->sector_id = $request->sector_id;
			$persona->direccion = $request->direccion;
			$persona->save();

			$constructor = new Constructor();
			$constructor->persona_sin_acceso_id = $persona->id;
			$constructor->save();

			return Response::json(['message' => 'Encargado Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		$constructor = Constructor::findOrFail($request->id);
		$persona = PersonaSinAcceso::findOrFail($constructor->persona_sin_acceso_id);
		$persona->nombres = $request->nombres;
		$persona->apellidos = $request->apellidos;
		$persona->genero = $request->genero;
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->sector_id = $request->sector_id;
		$persona->CUI = $request->CUI;
		$persona->numero_telefono = $request->numero_telefono;
		$persona->direccion = $request->direccion;
		
		$persona->save();
		$constructor->save();

	}

	public function activar(Request $request)
	{
		$constructor = Constructor::findOrFail($request->id);
        $persona = PersonaSinAcceso::findOrFail($constructor->id);

        $constructor->estado = '1';
        $persona->estado = '1';
        $constructor->save();
        $persona->save();
	}

	public function desactivar(Request $request)
	{
		$constructor = Constructor::findOrFail($request->id);
        $persona = PersonaSinAcceso::findOrFail($constructor->id);

        $constructor->estado = '0';
        $persona->estado = '0';
        $constructor->save();
        $persona->save();
	}
}