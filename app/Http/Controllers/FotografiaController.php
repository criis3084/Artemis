<?php

namespace App\Http\Controllers;

use App\Fotografia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class FotografiaController extends Controller
{
	public function index(Request $request)
    {
		// Filtro por un criterio y estado
        $buscar = $request->buscar;
        $criterio = $request->criterio;
		
		if ($buscar==''){
			$fotografia = Fotografia::orderBy('id', 'desc')->where('estado',1)->paginate(20);
		}
		else{
			$fotografia = Fotografia::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
        return [
            'pagination' => [
                'total'        => $fotografia->total(),
                'current_page' => $fotografia->currentPage(),
                'per_page'     => $fotografia->perPage(),
                'last_page'    => $fotografia->lastPage(),
                'from'         => $fotografia->firstItem(),
                'to'           => $fotografia->lastItem(),
            ],
            'fotografias' => $fotografia
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
            'aldeas' => $escuela
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
			$fotografia = new Fotografia();
			$fotografia->ruta = $request->ruta;
			$fotografia->descripcion = $request->descripcion;
			$fotografia->titulo = $request->titulo;
			$fotografia->save();
			return Response::json(['message' => 'Fotografia Subida'], 200);
		/*
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
		*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fotografia  $fotografia
     * @return \Illuminate\Http\Response
     */
    public function show(Fotografia $fotografia)
    {
		return [
			'id'=> $fotografia->id,
			'ruta'=> $fotografia->ruta,
			'titulo'=> $fotografia->titulo,
			'descripcion'=> $fotografia->descripcion
		];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fotografia  $fotografia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fotografia $fotografia)
    {
		$fotografia = Fotografia::findOrFail($request->id);
		$fotografia->ruta = $request->ruta;
		$fotografia->titulo = $request->titulo;
		$fotografia->descripcion = $request->descripcion;
		$fotografia->save();
		return Response::json(['message' => 'Fotografia Actualizada'], 200);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fotografia  $fotografia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fotografia $fotografia)
    {
		//if(!$request->ajax())return redirect('/');
        $fotografia = Fotografia::findOrFail($fotografia->id);
        $fotografia->estado = '0';
		$fotografia->save();
		return Response::json(['message' => 'Fotografia Desactivada'], 200);
    }
}
