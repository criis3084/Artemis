<?php

namespace App\Http\Controllers;

use App\Nino;
use Illuminate\Http\Request;

class NinoController extends Controller
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
     * @param  \App\Nino  $nino
     * @return \Illuminate\Http\Response
     */
    public function show(Nino $nino)
    {
        return[
			'codigo'=>$nino->codigo,
			'nombres'=>$nino->persona->nombres,
		];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nino  $nino
     * @return \Illuminate\Http\Response
     */
    public function edit(Nino $nino)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nino  $nino
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nino $nino)
    {
        //
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
}
