<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class UsuarioController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Usuario::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$usuario = Usuario::with('rol')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$usuario = Usuario::with('rol')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$usuario = Usuario::with('rol')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$usuario = Usuario::with('rol')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"usuarios"=>$usuario
		];
	}

	public function store(Request $request)
	{
		try {
			$usuario = new Usuario();
			$usuario->nombres = $request->nombres;
			$usuario->apellidos = $request->apellidos;
			$usuario->CUI = $request->CUI;
			$usuario->genero = $request->genero;
			$usuario->numero_telefono = $request->numero_telefono;
			$usuario->correo = $request->correo;
			$usuario->direccion = $request->direccion;
			$usuario->fecha_nacimiento = $request->fecha_nacimiento;
			$usuario->imagen_perfil = $request->correo;
			$usuario->descripcion = $request->descripcion;
			$usuario->usuario = $request->usuario;
			$usuario->password = $request->password;
			$usuario->rol_id = $request->rol_id;
			$usuario->save();
			return Response::json(['message' => 'Usuario Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$usuario = Usuario::findOrFail($request->id);
		$usuario->nombres = $request->nombres;
		$usuario->apellidos = $request->apellidos;
		$usuario->CUI = $request->CUI;
		$usuario->genero = $request->genero;
		$usuario->numero_telefono = $request->numero_telefono;
		$usuario->correo = $request->correo;
		$usuario->direccion = $request->direccion;
		$usuario->fecha_nacimiento = $request->fecha_nacimiento;
		$usuario->imagen_perfil = $request->correo;
		$usuario->descripcion = $request->descripcion;
		$usuario->usuario = $request->usuario;
		$usuario->password = $request->password;
		$usuario->rol_id = $request->rol_id;
		$usuario->save();
		return Response::json(['message' => 'Usuario Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$usuario = Usuario::findOrFail($request->id);
        $usuario->estado = '1';
        $usuario->save();
		return Response::json(['message' => 'usuario Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$usuario = Usuario::findOrFail($request->id);
        $usuario->estado = '0';
        $usuario->save();
		return Response::json(['message' => 'usuario Desactivado'], 200);
	}
}