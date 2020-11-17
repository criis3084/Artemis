<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class UserController extends Controller
{
	public function index(Request $request)
	{
		if (!$request->ajax()) return redirect('/');
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = User::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$user = User::with('rol')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$user = User::with('rol')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$user = User::with('rol')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$user = User::with('rol')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"users"=>$user
		];
	}

	public function store(Request $request)
	{
		try {
			$user = new User();
			$user->nombres = $request->nombres;
			$user->apellidos = $request->apellidos;
			$user->CUI = $request->CUI;
			$user->genero = $request->genero;
			$user->numero_telefono = $request->numero_telefono;
			$user->correo = $request->correo;
			$user->direccion = $request->direccion;
			$user->fecha_nacimiento = $request->fecha_nacimiento;
			$user->imagen_perfil = $request->correo;
			$user->descripcion = $request->descripcion;
			$user->user = $request->user;
			$user->password = Hash::make($request->password);
			$user->rol_id = $request->rol_id;
			$user->save();
			return Response::json(['message' => 'User Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$user = User::findOrFail($request->id);
		$user->nombres = $request->nombres;
		$user->apellidos = $request->apellidos;
		$user->CUI = $request->CUI;
		$user->genero = $request->genero;
		$user->numero_telefono = $request->numero_telefono;
		$user->correo = $request->correo;
		$user->direccion = $request->direccion;
		$user->fecha_nacimiento = $request->fecha_nacimiento;
		$user->imagen_perfil = $request->correo;
		$user->descripcion = $request->descripcion;
		$user->user = $request->user;
		$user->password = $request->password;
		$user->rol_id = $request->rol_id;
		$user->save();
		return Response::json(['message' => 'User Actualizado'], 200);

	}

	public function activar(Request $request)
	{
		$user = User::findOrFail($request->id);
        $user->estado = '1';
        $user->save();
		return Response::json(['message' => 'user Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$user = User::findOrFail($request->id);
        $user->estado = '0';
        $user->save();
		return Response::json(['message' => 'user Desactivado'], 200);
	}
}