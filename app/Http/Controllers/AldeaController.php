<?php

namespace App\Http\Controllers;

use App\Aldea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class AldeaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		//if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
		
		if ($buscar==''){
      $aldea = Aldea::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as aldea', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);		}
		else{
			$aldea = Aldea::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
		}
		
        return [
            'pagination' => [
                'total'        => $aldea->total(),
                'current_page' => $aldea->currentPage(),
                'per_page'     => $aldea->perPage(),
                'last_page'    => $aldea->lastPage(),
                'from'         => $aldea->firstItem(),
                'to'           => $aldea->lastItem(),
            ],
            'aldeas' => $aldea
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
			$aldea = new Aldea();
			$aldea->nombre = $request->nombre;
			$aldea->save();
			return Response::json(['message' => 'Aldea Creada'], 200);
		/*
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
		*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Aldea  $aldea
     * @return \Illuminate\Http\Response
     */
    public function show(Aldea $aldea)
    {
		return [
			'id'=> $aldea->id,
			'nombre'=> $aldea->nombre,
			'sectores'=> $aldea->sectores,
		];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Aldea  $aldea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$aldea = Aldea::findOrFail($request->id);
		$aldea->nombre = $request->nombre;
		$aldea->save();
		return Response::json(['message' => 'Aldea Actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Aldea  $aldea
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aldea $aldea)
    {
        //
    }
}
