<?php

namespace App\Http\Controllers;

use App\Tutor;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Image;
use Illuminate\Support\Facades\File;

class TutorController extends Controller
{
	public function index(Request $request)
	{
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			$count = Tutor::where('estado',1)->count();
			if ($buscar==''){
				$tutor = Tutor::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tutor = Tutor::with('datos')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			$count = Tutor::all()->count();
			if ($buscar==''){
				$tutor = Tutor::with('datos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tutor = Tutor::with('datos')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
			}
		}else if($completo == 'datosAnidados')
		{
			$tutor = Tutor::with('datos')->with('tutorias')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate($count);
		}
		return [
			"tutors"=>$tutor
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
			$usuario->save();
			
			$tutor = new Tutor();
			$tutor->especialidad = $request->especialidad;
			// $tutor->usuario_id = $usario->usuario_id;
			$tutor->usuario_id = $usuario->id;
			$tutor->save();
			return Response::json(['message' => 'Usuario tutor Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	
	public function update(Request $request)
	{
		try {
		$tutor = Tutor::findOrFail($request->id);
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
			
			$tutor->especialidad = $request->especialidad;
			// $tutor->usuario_id = $usario->usuario_id;
			//$tutor->usuario_id = $usuario->id;
		
			$usuario->save();
		    $tutor->save();
		    return Response::json(['message' => 'Usuario tutor actualizado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
		
	}

	public function activar(Request $request)
	{
		 #if(!$request->ajax())return redirect('/');
		 $tutor = Tutor::findOrFail($request->id);
		 $usuario = Usuario::findOrFail($tutor->usuario_id);
		 $usuario->estado = '1';
		 $tutor->estado = '1';
		 $tutor->save();
		 $usuario->save();
		 return Response::json(['message' => 'Tutor Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tutor = Tutor::findOrFail($request->id);
        $usuario = Usuario::findOrFail($tutor->usuario_id);
		$usuario->estado = '0';
		$tutor->estado = '0';
		$tutor->save();
		$usuario->save();
		return Response::json(['message' => 'Tutor Desactivado'], 200);
	}
	public function imagen(Request $request){
		$imagen = $request->photos;
		$nombreEliminar = public_path('storage\public\tutores\\') .  $request->header("imagenanterior");
		if (File::exists($nombreEliminar)) {
			File::delete($nombreEliminar);
		}
		$completo = time() . "." . $imagen->extension();
		$imagen->move(public_path('storage/public/tutores/'), $completo);
		return Response::json($completo, 200);
	}
}