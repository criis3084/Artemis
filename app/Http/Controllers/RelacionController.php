<?php

namespace App\Http\Controllers;

use App\Relacion;
use Illuminate\Http\Request;

class RelacionController extends Controller
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
     * @param  \App\Relacion  $relacion
     * @return \Illuminate\Http\Response
     */
    public function show(Relacion $relacion)
    {
        return [
			'Nombre_Nino'=>$relacion->nino->datos->nombres,
			'Nombre_Encargado'=>$relacion->encargado->datos->nombres
		];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Relacion  $relacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Relacion $relacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Relacion  $relacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Relacion $relacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Relacion  $relacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Relacion $relacion)
    {
        //
    }
}
