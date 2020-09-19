<?php

namespace App\Http\Controllers;

use App\Nino;
use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class NinoController extends Controller
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
				$nino = Nino::with('datos')->with('escuela')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$nino = Nino::with('datos')->with('escuela')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$nino = Nino::with('datos')->with('escuela')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$nino = Nino::with('datos')->with('escuela')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $nino->total(),
				'current_page' => $nino->currentPage(),
				'per_page'     => $nino->perPage(),
				'last_page'    => $nino->lastPage(),
				'from'         => $nino->firstItem(),
				'to'           => $nino->lastItem(),
			],
			"ninos"=>$nino
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
			$persona->genero = $request->genero;
			$persona->fecha_nacimiento = $request->fecha_nacimiento;
			$persona->sector_id = $request->sector_id;
			$persona->direccion = $request->direccion;
			$persona->save();
			
            $nino = new Nino();
            $nino->codigo = $request->codigo;
            $nino->fecha_ingreso = $request->fecha_ingreso;
            $nino->fecha_egreso = $request->fecha_egreso;
            $nino->ruta_imagen = $request->ruta_imagen;
            $nino->persona_sin_acceso_id = $persona->id;
            $nino->escuela_id = $request->escuela_id;
            $nino->save();

            return Response::json(['message' => 'Nino Creado'], 200);
            #return ['id' => $nino->id];
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nino  $nino
     * @return \Illuminate\Http\Response
     */
    public function show(Nino $nino)
    {
        return[
			'codigo'=>$nino->codigo,
			'nombres'=>$nino->datos->nombres,
		];
    }

	public function update(Request $request, Nino $nino)
    {
		/*
		$nino = Nino::findOrFail($request->id);
		$persona = PersonaSinAcceso::findOrFail($nino->persona_sin_acceso_id);

		$persona->nombres = $request->nombres;
		$persona->apellidos = $request->apellidos;
		$persona->genero = $request->genero;
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->sector_id = $request->sector_id;
		$persona->direccion = $request->direccion;
		$nino->codigo        = $request->codigo;
		$nino->fecha_ingreso = $request->fecha_ingreso;
		$nino->fecha_egreso  = $request->fecha_egreso;
		$nino->ruta_imagen   = $request->ruta_imagen;
		$nino->escuela_id    = $request->escuela_id;
		
		$nino->save();
		$persona->save();
		*/
		return Response::json(['message' => 'Nino Actualizada'], 200);
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nino  $nino
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nino $nino)
    {
        //
	}
	
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $nino = Nino::findOrFail($request->id);
        $persona = PersonaSinAcceso::findOrFail($nino->id);

        $nino->estado = '0';
        $persona->estado = '0';
        $nino->save();
        $persona->save();
    }
}
