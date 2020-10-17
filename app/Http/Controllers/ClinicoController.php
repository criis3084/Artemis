<?php

namespace App\Http\Controllers;

use App\Clinico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ClinicoController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Clinico::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$clinico = Clinico::with('detalle_integrante')->with('usuario')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$clinico = Clinico::with('detalle_integrante')->with('usuario')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$clinico = Clinico::with('detalle_integrante')->with('usuario')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$clinico = Clinico::with('detalle_integrante')->with('usuario')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"clinicos"=>$clinico
		];
	}

	public function store(Request $request)
	{
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
			$usuario->save();
			
			$clinico = new Clinico();
			$clinico->profesion_id = $request->profesion_id;
			$clinico->usuario_id = $usuario->id;
			$clinico->save();
			return Response::json(['message' => 'Usuario clinico Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		try {
		$clinico = Clinico::findOrFail($request->id);
		$usuario = Usuario::findOrFail($tutor->usuario_id);
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
		

		$clinico->profesion_id = $request->profesion_id;
		$clinico->usuario_id = $usuario->id;
		$clinico->save();
		$usuario->save();
		return Response::json(['message' => 'Usuario clinico actualizado'], 200);
		#return ['id' => $nino->id];
	} catch (Exception $e) {
		return Response::json(['message' => $e->getMessage()], 400);
	}
	}

	public function activar(Request $request)
	{
		$clinico = Clinico::findOrFail($request->id);
		$usuario = Usuario::findOrFail($tutor->usuario_id);
		$usuario->estado = '1';
		$clinico->estado = '1';
		$clinico->save();
		$usuario->save();
		return Response::json(['message' => 'clinico Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$clinico = Clinico::findOrFail($request->id);
		$usuario = Usuario::findOrFail($tutor->usuario_id);
		$usuario->estado = '0';
		$clinico->estado = '0';
		$clinico->save();
		$usuario->save();
		return Response::json(['message' => 'clinico Desactivado'], 200);
	}
}