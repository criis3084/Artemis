<?php

namespace App\Http\Controllers;

use App\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$buscar = $request->buscar;
        $criterio = $request->criterio;
		
		if ($buscar==''){
			$sector = Sector::orderBy('id', 'desc')->paginate(20);
		}
		else{
			$sector = Sector::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
        return [
            'pagination' => [
                'total'        => $sector->total(),
                'current_page' => $sector->currentPage(),
                'per_page'     => $sector->perPage(),
                'last_page'    => $sector->lastPage(),
                'from'         => $sector->firstItem(),
                'to'           => $sector->lastItem(),
            ],
            'sectores' => $sector
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
			$sector = new Sector();
			$sector->nombre = $request->nombre;
			$sector->aldea_id = $request->aldea_id;
			$sector->save();
			return Response::json(['message' => 'Sector Creado'], 200);
		/*
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
		*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show(Sector $sector)
    {
		return [
			'id'=> $sector->id,
			'nombre'=> $sector->nombre,
			'aldea_id'=> $sector->aldea_id,
			'aldea_nombre'=> $sector->aldea->nombre,
		];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sector $sector)
    {
		$sector = Sector::findOrFail($request->id);
		$sector->nombre = $request->nombre;
		$sector->aldea_id = $request->aldea_id;
		$sector->save();
		return Response::json(['message' => 'Sector Actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sector $sector)
    {
        //
    }
}
