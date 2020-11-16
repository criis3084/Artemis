<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Tutor;
use App\User;
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
		$count = Tutor::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$tutor = Tutor::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$tutor = Tutor::with('datos')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$tutor = Tutor::with('datos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$tutor = Tutor::with('datos')->where($criterio, 'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}else if($completo == 'datosAnidados')
		{
			$tutor = Tutor::with('datos')->with('tutorias')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
		}
		return [
			"tutors"=>$tutor
		];
	}

	public function store(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		try {
			$user= new User();
			$user->nombres = $request->nombres;
			$user->apellidos = $request->apellidos;
			$user->CUI = $request->CUI;
			$user->genero = $request->genero;
			$user->numero_telefono = $request->numero_telefono;
			$user->correo = $request->correo;
			$user->direccion = $request->direccion;
			$user->fecha_nacimiento = $request->fecha_nacimiento;
			$user->imagen_perfil = $request->imagen_perfil;
			$user->descripcion = $request->descripcion;
			// Comprobacion de unico
			$user->user = $request->user;
			$user->password = Hash::make($request->password);
			//$user->password = $request->password;
			$user->rol_id = $request->rol_id;
			$user->save();
			
			$tutor = new Tutor();
			$tutor->especialidad = $request->especialidad;
			// $tutor->user_id = $usario->user_id;
			$tutor->user_id = $user->id;
			$tutor->save();
			return Response::json(['message' => 'User tutor Creado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	
	public function update(Request $request)
	{
		try {
		$tutor = Tutor::findOrFail($request->id);
		$user = User::findOrFail($tutor->user_id);
		$user->nombres = $request->nombres;
			$user->apellidos = $request->apellidos;
			$user->CUI = $request->CUI;
			$user->genero = $request->genero;
			$user->numero_telefono = $request->numero_telefono;
			$user->correo = $request->correo;
			$user->direccion = $request->direccion;
			$user->fecha_nacimiento = $request->fecha_nacimiento;
			$user->imagen_perfil = $request->imagen_perfil;
			$user->descripcion = $request->descripcion;
			// Comprobacion de unico
			$user->user = $request->user;
			$user->password = $request->password;
			$user->rol_id = $request->rol_id;
			
			$tutor->especialidad = $request->especialidad;
			// $tutor->user_id = $usario->user_id;
			//$tutor->user_id = $user->id;
		
			$user->save();
		    $tutor->save();
		    return Response::json(['message' => 'User tutor actualizado'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
		
	}

	public function activar(Request $request)
	{
		 #if(!$request->ajax())return redirect('/');
		 $tutor = Tutor::findOrFail($request->id);
		 $user = User::findOrFail($tutor->user_id);
		 $user->estado = '1';
		 $tutor->estado = '1';
		 $tutor->save();
		 $user->save();
		 return Response::json(['message' => 'Tutor Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tutor = Tutor::findOrFail($request->id);
        $user = User::findOrFail($tutor->user_id);
		$user->estado = '0';
		$tutor->estado = '0';
		$tutor->save();
		$user->save();
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