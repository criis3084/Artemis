<?php

namespace App\Http\Controllers;

use App\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class EscuelaController extends Controller
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
				$escuela = Escuela::orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$escuela = Escuela::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$escuela = Escuela::orderBy('id', 'desc')->paginate(20);
			}
			else{
				$escuela = Escuela::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
        return [
            'pagination' => [
                'total'        => $escuela->total(),
                'current_page' => $escuela->currentPage(),
                'per_page'     => $escuela->perPage(),
                'last_page'    => $escuela->lastPage(),
                'from'         => $escuela->firstItem(),
                'to'           => $escuela->lastItem(),
            ],
            'escuelas' => $escuela
		];
		
		// Filtro solo por un criterio 
		/*
		$buscar = $request->buscar;
        $criterio = $request->criterio;
		
			if ($buscar==''){
				$escuela = Escuela::orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$escuela = Escuela::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
        return [
            'pagination' => [
                'total'        => $escuela->total(),
                'current_page' => $escuela->currentPage(),
                'per_page'     => $escuela->perPage(),
                'last_page'    => $escuela->lastPage(),
                'from'         => $escuela->firstItem(),
                'to'           => $escuela->lastItem(),
            ],
            'escuelas' => $escuela
		];
		*/
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
			$escuela = new Escuela();
			$escuela->nombre = $request->nombre;
			$escuela->direccion = $request->direccion;
			$escuela->save();
			return Response::json(['message' => 'Escuela Creada'], 200);
		/*
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
		*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function show(Escuela $escuela)
    {
		return [
			'id'=> $escuela->id,
			'nombre'=> $escuela->nombre,
			'direccion'=> $escuela->direccion,
			'ninos'=> $escuela->ninos
		];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Escuela $escuela)
    {
		$escuela = Escuela::findOrFail($request->id);
		$escuela->nombre = $request->nombre;
		$escuela->direccion = $request->direccion;
		$escuela->save();
		return Response::json(['message' => 'Escuela Actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Escuela  $escuela
     * @return \Illuminate\Http\Response
     */
    public function destroy(Escuela $escuela)
    {
		// Temporal estado de desactivacion

		//if(!$request->ajax())return redirect('/');
        $escuela = Escuela::findOrFail($escuela->id);
        $escuela->estado = '0';
		$escuela->save();
		return Response::json(['message' => 'Escuela Desactivado'], 200);
    }
}
