<?php

namespace App\Http\Controllers;

use App\DestinoInversion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class DestinoInversionController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
		if ($buscar==''){
			$destinoInversion = DestinoInversion::orderBy('id', 'desc')->paginate(20);
			#$destinoInversion = DestinoInversion::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as destinoInversion', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$destinoInversion = DestinoInversion::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $destinoInversion->total(),
                'current_page' => $destinoInversion->currentPage(),
                'per_page'     => $destinoInversion->perPage(),
                'last_page'    => $destinoInversion->lastPage(),
                'from'         => $destinoInversion->firstItem(),
                'to'           => $destinoInversion->lastItem(),
            ],
            'destinosInversiones' => $destinoInversion
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$destinoInversion = new DestinoInversion();
			$destinoInversion->nombre = $request->nombre;
			$destinoInversion->save();
			return Response::json(['message' => 'DestinoInversion Creada'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }
    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$destinoInversion = DestinoInversion::findOrFail($request->id);
		$destinoInversion->nombre = $request->nombre;
		$destinoInversion->save();
		return Response::json(['message' => 'DestinoInversion Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $destinoInversion = DestinoInversion::findOrFail($request->id);
        $destinoInversion->estado = '1';
        $destinoInversion->save();
		return Response::json(['message' => 'DestinoInversion Activada'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$destinoInversion = DestinoInversion::findOrFail($request->id);
		$destinoInversion->estado = '0';
		$destinoInversion->save();
		return Response::json(['message' => 'DestinoInversion Desactivada'], 200);
	}
}