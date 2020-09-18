<?php

namespace App\Http\Controllers;

use App\PersonaSinAcceso;
use Illuminate\Http\Request;

class PersonaSinAccesoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
			"genero"=>$personaSinAcceso->genero,
			"fecha_nacimiento"=>$personaSinAcceso->fecha_nacimiento,
			"direccion"=>$personaSinAcceso->direccion,
			"numero_telefono"=>$personaSinAcceso->numero_telefono,
			'Sector' => $personaSinAcceso->sector,
			'nombre_sector' => $personaSinAcceso->sector->nombre,
			'nino' => $nino,
		];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PersonaSinAcceso  $personaSinAcceso
     * @return \Illuminate\Http\Response
     */
    public function edit(PersonaSinAcceso $personaSinAcceso)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PersonaSinAcceso  $personaSinAcceso
     * @return \Illuminate\Http\Response
     */
    public function destroy(PersonaSinAcceso $personaSinAcceso)
    {
        //
    }
}
