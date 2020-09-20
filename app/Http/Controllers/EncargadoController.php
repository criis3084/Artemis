<?php

namespace App\Http\Controllers;

use App\Encargado;
use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class EncargadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		// Filtro por un criterio y estado
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : $completo = 'false';
		
		if ($completo == 'false')
		{
			if ($buscar==''){
				$encargado = Encargado::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$encargado = Encargado::with('datos')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$encargado = Encargado::with('datos')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$encargado = Encargado::with('datos')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $encargado->total(),
				'current_page' => $encargado->currentPage(),
				'per_page'     => $encargado->perPage(),
				'last_page'    => $encargado->lastPage(),
				'from'         => $encargado->firstItem(),
				'to'           => $encargado->lastItem(),
			],
			"encargados"=>$encargado
		];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            $encargado->persona_sin_acceso_id = $persona->id;
            $encargado->save();

            return Response::json(['message' => 'Encargado Creado'], 200);
            #return ['id' => $nino->id];
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function show(Encargado $encargado)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Encargado $encargado)
    {
		
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
		$persona->save();
		$encargado->save();
		
		return Response::json(['message' => 'Nino Actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Encargado  $encargado
     * @return \Illuminate\Http\Response
     */
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $encargado = Encargado::findOrFail($request->id);
        $persona = PersonaSinAcceso::findOrFail($encargado->id);

        $encargado->estado = '0';
        $persona->estado = '0';
        $encargado->save();
        $persona->save();
    }
}
