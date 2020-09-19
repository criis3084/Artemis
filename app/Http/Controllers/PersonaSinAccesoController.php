<?php

namespace App\Http\Controllers;

use App\PersonaSinAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class PersonaSinAccesoController extends Controller
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
				$completo = $request->completo;
				
				if ($completo == 'false')
				{
					if ($buscar==''){
						$persona_sin_acceso = PersonaSinAcceso::orderBy('id', 'desc')->where('estado',1)->paginate(20);
					}
					else{
						$persona_sin_acceso = PersonaSinAcceso::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
					}
				} else if ($completo == 'true'){
					if ($buscar==''){
						$persona_sin_acceso = PersonaSinAcceso::orderBy('id', 'desc')->paginate(20);
					}
					else{
						$persona_sin_acceso = PersonaSinAcceso::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
					}
				}
				return [
					'pagination' => [
						'total'        => $persona_sin_acceso->total(),
						'current_page' => $persona_sin_acceso->currentPage(),
						'per_page'     => $persona_sin_acceso->perPage(),
						'last_page'    => $persona_sin_acceso->lastPage(),
						'from'         => $persona_sin_acceso->firstItem(),
						'to'           => $persona_sin_acceso->lastItem(),
					],
					'personas' => $persona_sin_acceso
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
				/*
		if(!$request->ajax())return redirect('/');
        try {
			*/
			$persona = new PersonaSinAcceso();
			$persona->nombres = $request->nombres;
			$persona->apellidos = $request->apellidos;
			$persona->CUI = $request->CUI;
			$persona->genero = $request->genero;
			$persona->fecha_nacimiento = $request->fecha_nacimiento;
			$persona->direccion = $request->direccion;
			$persona->numero_telefono = $request->numero_telefono;
			$persona->sector_id = $request->sector_id;
			$persona->save();
			return Response::json(['message' => 'Persona Creada'], 200);
		/*
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
		*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PersonaSinAcceso  $personaSinAcceso
     * @return \Illuminate\Http\Response
     */
    public function show(PersonaSinAcceso $personaSinAcceso)
    {
		$nino = $personaSinAcceso->nino();
		//dd($nino);
        return[
			"nombres" => $personaSinAcceso->nombres,
			"apellidos"=>$personaSinAcceso->apellidos,
			"CUI"=>$personaSinAcceso->CUI,
			"genero"=>$personaSinAcceso->genero,
			"fecha_nacimiento"=>$personaSinAcceso->fecha_nacimiento,
			"direccion"=>$personaSinAcceso->direccion,
			"numero_telefono"=>$personaSinAcceso->numero_telefono,
			'sector_id' => $personaSinAcceso->sector_id,
			'sector_nombre' => $personaSinAcceso->sector->nombre
		];
    }
                           
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PersonaSinAcceso  $personaSinAcceso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PersonaSinAcceso $personaSinAcceso)
    {
		$persona = PersonaSinAcceso::findOrFail($request->id);
		$persona->nombres = $request->nombres;
		$persona->apellidos = $request->apellidos;
		$persona->CUI = $request->CUI;
		$persona->genero = $request->genero;
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->direccion = $request->direccion;
		$persona->numero_telefono = $request->numero_telefono;
		$persona->sector_id = $request->sector_id;
		$persona->save();
		return Response::json(['message' => 'Sector Actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaSinAcceso  $personaSinAcceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonaSinAcceso $personaSinAcceso)
    {
		$personaSinAcceso = PersonaSinAcceso::findOrFail($personaSinAcceso->id);
        $personaSinAcceso->estado = '0';
		$personaSinAcceso->save();
		return Response::json(['message' => 'Persona Desactivado'], 200);
    }
}
