<?php

namespace App\Http\Controllers;

use App\Administrativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class AdministrativoController extends Controller
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
				$administrativo = Administrativo::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$administrativo = Administrativo::with('datos')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$administrativo = Administrativo::with('datos')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$administrativo = Administrativo::with('datos')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $administrativo->total(),
				'current_page' => $administrativo->currentPage(),
				'per_page'     => $administrativo->perPage(),
				'last_page'    => $administrativo->lastPage(),
				'from'         => $administrativo->firstItem(),
				'to'           => $administrativo->lastItem(),
			],
			"administrativos"=>$administrativo
		];
	}

	public function store(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$usuario= new Usuario();
			$usuario->nombres = $request->nombres;
			$usuario->apellidos = $request->apellidos;
			$usuario->CUI = $request->CUI;
			$usuario->genero = $request->genero;
			$usuario->numero_telefono = $request->numero_telefono;
			$usuario->correo = $request->correo;
			$usuario->direccion = $request->direccion;
			$usuario->fecha_nacimiento = $request->fecha_nacimiento;
			$usuario->imagen_perfil = $request->imagen_perfil;
			$usuario->descripcion = $request->descripcion;
			// Comprobacion de unico
			$usuario->usuario = $request->usuario;
			$usuario->password = $request->password;
			$usuario->rol_id = $request->rol_id;

			$administrativo = new Administrativo();
			$administrativo->descripcion_puesto = $request->descripcion_puesto;
			$administrativo->usuario_id = $usario->usuario_id;
			$administrativo->save();
			return Response::json(['message' => 'Usuario administrativo Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$administrativo= Administrativo::findOrFail($request->id);
			$usuario= Usuario::findOrFail($administrativo->usuario_id);
			$usuario->nombres = $request->nombres;
			$usuario->apellidos = $request->apellidos;
			$usuario->CUI = $request->CUI;
			$usuario->genero = $request->genero;
			$usuario->numero_telefono = $request->numero_telefono;
			$usuario->correo = $request->correo;
			$usuario->direccion = $request->direccion;
			$usuario->fecha_nacimiento = $request->fecha_nacimiento;
			$usuario->imagen_perfil = $request->imagen_perfil;
			$usuario->descripcion = $request->descripcion;
			// Comprobacion de unico
			#$usuario->usuario = $request->usuario;
			$usuario->password = $request->password;
			$usuario->rol_id = $request->rol_id;

			$administrativo->descripcion_puesto = $request->descripcion_puesto;
			$administrativo->save();
			return Response::json(['message' => 'Usuario administrativo Actualizado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $administrativo = Administrativo::findOrFail($request->id);
        $usuario = Usuario::findOrFail($administrativo->usuario_id);
		$usuario->estado = '0';
        $administrativo->estado = '1';
        $administrativo->save();
        $usuario->save();
		return Response::json(['message' => 'Persona administrativa Activada'], 200);
	}

	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$administrativo = Administrativo::findOrFail($request->id);
        $usuario = Usuario::findOrFail($administrativo->usuario_id);
		$usuario->estado = '0';
		$administrativo->estado = '0';
		$administrativo->save();
		$usuario->save();
		return Response::json(['message' => 'Personal administrativo Desactivado'], 200);
	}
}