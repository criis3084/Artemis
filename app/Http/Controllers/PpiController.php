<?php

namespace App\Http\Controllers;

use App\Fotografia;
use App\Ppi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class PpiController extends Controller
{

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
			$ppi = new Ppi();
			$ppi->respuesta1 = $request->respuesta1;
			$ppi->respuesta2 = $request->respuesta2;
			$ppi->respuesta3 = $request->respuesta3;
			$ppi->respuesta4 = $request->respuesta4;
			$ppi->respuesta5 = $request->respuesta5;
			$ppi->respuesta6 = $request->respuesta6;
			$ppi->respuesta7 = $request->respuesta7;
			$ppi->respuesta8 = $request->respuesta8;
			$ppi->respuesta9 = $request->respuesta9;
			$ppi->respuesta10 = $request->respuesta10;
			$ppi->total = $request->total;
			$ppi->save();
			return Response::json(['message' => 'Ppi Creado'], 200);
		/*
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
		*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ppi  $ppi
     * @return \Illuminate\Http\Response
     */
    public function show(Ppi $ppi)
    {
		return [
			'id'=> $ppi->id,
			'respuesta1'=> $ppi->respuesta1,
			'respuesta2'=> $ppi->respuesta2,
			'respuesta3'=> $ppi->respuesta3,
			'respuesta4'=> $ppi->respuesta4,
			'respuesta5'=> $ppi->respuesta5,
			'respuesta6'=> $ppi->respuesta6,
			'respuesta7'=> $ppi->respuesta7,
			'respuesta8'=> $ppi->respuesta8,
			'respuesta9'=> $ppi->respuesta9,
			'respuesta10'=> $ppi->respuesta10,
			'total'=> $ppi->total
		];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ppi  $ppi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ppi $ppi)
    {
		$ppi = Ppi::findOrFail($request->id);
		$ppi->respuesta1 = $request->respuesta1;
		$ppi->respuesta2 = $request->respuesta2;
		$ppi->respuesta3 = $request->respuesta3;
		$ppi->respuesta4 = $request->respuesta4;
		$ppi->respuesta5 = $request->respuesta5;
		$ppi->respuesta6 = $request->respuesta6;
		$ppi->respuesta7 = $request->respuesta7;
		$ppi->respuesta8 = $request->respuesta8;
		$ppi->respuesta9 = $request->respuesta9;
		$ppi->respuesta10 = $request->respuesta10;
		$ppi->total = $request->total;
		$ppi->save();
		return Response::json(['message' => 'Ppi Actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ppi  $ppi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ppi $ppi)
    {
		$ppi = Ppi::findOrFail($ppi->id);
        $ppi->estado = '0';
		$ppi->save();
		return Response::json(['message' => 'Ppi Desactivado'], 200);
    }
}
