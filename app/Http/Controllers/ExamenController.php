<?php

namespace App\Http\Controllers;

use App\Examen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ExamenController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Examen::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$examen = Examen::with('tipoExamen')->with('laboratorista')->with('datos_laboratorista')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$examen = Examen::with('tipoExamen')->with('laboratorista')->with('datos_laboratorista')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$examen = Examen::with('tipoExamen')->with('laboratorista')->with('datos_laboratorista')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$examen = Examen::with('tipoExamen')->with('laboratorista')->with('datos_laboratorista')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"examenes"=>$examen
		];
	}

	public function store(Request $request)
	{
		try {
			$examen = new Examen();
			$examen->descripcion = $request->descripcion;
			$examen->resultado = $request->resultado;
			$examen->fecha_examen = $request->fecha_examen;
			$examen->tipo_examen_id = $request->tipo_examen_id;
			$examen->clinico_id = $request->clinico_id;
			if (isset($request->ruta_imagen)){
				$examen->ruta_imagen = $request->ruta_imagen;
			}
			$examen->save();
			#return Response::json(['message' => 'Examen Creada'], 200);
			return ['id' => $examen->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$examen = Examen::findOrFail($request->id);
		$examen->descripcion = $request->descripcion;
		$examen->resultado = $request->resultado;
		$examen->fecha_examen = $request->fecha_examen;
		$examen->tipo_examen_id = $request->tipo_examen_id;
		$examen->clinico_id = $request->clinico_id;
		if (isset($request->ruta_imagen)){
			$examen->ruta_imagen = $request->ruta_imagen;
		}
		if (isset($request->estado)){
			$examen->estado = $request->estado;
		}
		$examen->save();
		return Response::json(['message' => 'Examen Actualizado'], 200);
		
	}

	public function activar(Request $request)
	{
		$examen = Examen::findOrFail($request->id);
        $examen->estado = '1';
        $examen->save();
		return Response::json(['message' => 'examen Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$examen = Examen::findOrFail($request->id);
        $examen->estado = '0';
        $examen->save();
		return Response::json(['message' => 'examen desactivado'], 200);
	}
	public function imagen(Request $request){
		$imagen = $request->photos;

		$nombreEliminar = public_path('storage\public\examenes\\') .  $request->header("imagenanterior");
		if (File::exists($nombreEliminar)) {
			File::delete($nombreEliminar);
		}
		
		$completo = time() . "." . $imagen->extension();
		$imagen_redi = Image::make($imagen)->resize(300,200);
		$imagen_redi->save(public_path('storage/public/examenes/'. $completo));
		return Response::json($completo, 200);
	}
}