<?php

namespace App\Http\Controllers;

use App\Relacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class RelacionController extends Controller
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
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->where($criterio, 'like', '%'. $buscar . '%')->where('estado',1)->orderBy('id', 'desc')->paginate(20);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$relacion = Relacion::with('nino')->with('encargado')->with('sector')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		return [
			'pagination' => [
				'total'        => $relacion->total(),
				'current_page' => $relacion->currentPage(),
				'per_page'     => $relacion->perPage(),
				'last_page'    => $relacion->lastPage(),
				'from'         => $relacion->firstItem(),
				'to'           => $relacion->lastItem(),
			],
			"relaciones"=>$relacion
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
			$relacion = new Relacion();
			$relacion->relacion = $request->relacion;
			$relacion->direccion = $request->direccion;
			$relacion->codigo = $request->codigo;
			$relacion->nino_id = $request->nino_id;
			$relacion->encargado_id = $request->encargado_id;
			$relacion->sector_id = $request->sector_id;
			$relacion->save();
			return Response::json(['message' => 'Relacion Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Relacion  $relacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Relacion $relacion)
    {
		//if(!$request->ajax())return redirect('/');
		$relacion = Relacion::findOrFail($request->id);
		$relacion->relacion = $request->relacion;
		$relacion->direccion = $request->direccion;
		$relacion->codigo = $request->codigo;
		// Actualizar direccion del ni;o del encargado
		// Pendiente
		$relacion->save();
		
		return Response::json(['message' => 'Relazion Acualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Relacion  $relacion
     * @return \Illuminate\Http\Response
     */
	public function desactivar(Request $request)
    {
        #if(!$request->ajax())return redirect('/');
        $relacion = Relacion::findOrFail($request->id);
        $relacion->estado = '0';
        $relacion->save();
		return Response::json(['message' => 'Relacion Desactivada'], 200);
	}
}
