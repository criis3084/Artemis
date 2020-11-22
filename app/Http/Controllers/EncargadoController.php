<?php

namespace App\Http\Controllers;

use App\Encargado;
use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class EncargadoController extends Controller
{

    public function index(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Encargado::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$encargado = Encargado::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$encargado = Encargado::with('datos')->where([[$criterio, 'like', $buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$encargado = Encargado::with('datos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$encargado = Encargado::with('datos')->where($criterio, 'like', $buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"encargados"=>$encargado
		];
    }

    public function store(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
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

            $encargado = new Encargado();
            $encargado->ruta_imagen = $request->ruta_imagen;
            $encargado->ocupacion = $request->ocupacion;
            $encargado->escolaridad = $request->escolaridad;
            $encargado->ingresos = $request->ingresos;
            $encargado->persona_sin_acceso_id = $persona->id;
            $encargado->save();

			return ['id' => $encargado->id];
            return Response::json(['message' => 'Encargado Creado'], 200);
            #return ['id' => $nino->id];
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Encargado $encargado)
    {
        //
    }

    public function update(Request $request, Encargado $encargado)
    {
		#if(!$request->ajax())return redirect('/');		
		$encargado = Encargado::findOrFail($request->id);
		$persona = PersonaSinAcceso::findOrFail($encargado->persona_sin_acceso_id);

		$persona->nombres = $request->nombres;
		$persona->apellidos = $request->apellidos;
		$persona->genero = $request->genero;
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->sector_id = $request->sector_id;
		$persona->CUI = $request->CUI;
		$persona->numero_telefono = $request->numero_telefono;
		$persona->direccion = $request->direccion;

		$encargado->ruta_imagen = $request->ruta_imagen;
		$encargado->ocupacion = $request->ocupacion;
		$encargado->escolaridad = $request->escolaridad;
		$encargado->ingresos = $request->ingresos;
		$persona->save();
		$encargado->save();
		return Response::json(['message' => 'Nino Actualizada'], 200);
    }

	public function activar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$encargado = Encargado::findOrFail($request->id);
		$persona = PersonaSinAcceso::findOrFail($encargado->id);

		$encargado->estado = '1';
		$persona->estado = '1';
		$encargado->save();
		$persona->save();
	}
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$encargado = Encargado::findOrFail($request->id);
		$persona = PersonaSinAcceso::findOrFail($encargado->id);

		$encargado->estado = '0';
		# la pesona no se debe desactiar porque puede seguir yendo a consultas?
        # $persona->estado = '0';
		$persona->estado = '0';
		$encargado->save();
		$persona->save();
	}
	public function imagen(Request $request){
		$imagen = $request->photos;
		$nombreEliminar = public_path('storage\public\familiares\\') .  $request->header("imagenanterior");
		if (File::exists($nombreEliminar)) {
			File::delete($nombreEliminar);
		}
		$completo = time() . "." . $imagen->extension();
		$imagen_redi = Image::make($imagen)->resize(300,200);
		$imagen_redi->save(public_path('storage/public/familiares/'. $completo));
		return Response::json($completo, 200);
	}
}
