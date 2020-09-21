<?php

namespace App\Http\Controllers;

use App\CategoriaMedicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class CategoriaMedicamentoController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
		if ($buscar==''){
			$categoriaMedicamento = CategoriaMedicamento::orderBy('id', 'desc')->paginate(20);
			#$categoriaMedicamento = CategoriaMedicamento::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as categoriaMedicamento', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$categoriaMedicamento = CategoriaMedicamento::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $categoriaMedicamento->total(),
                'current_page' => $categoriaMedicamento->currentPage(),
                'per_page'     => $categoriaMedicamento->perPage(),
                'last_page'    => $categoriaMedicamento->lastPage(),
                'from'         => $categoriaMedicamento->firstItem(),
                'to'           => $categoriaMedicamento->lastItem(),
            ],
            'CategoriaMedicamentos' => $categoriaMedicamento
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$categoriaMedicamento = new CategoriaMedicamento();
			$categoriaMedicamento->nombre = $request->nombre;
			$categoriaMedicamento->descripcion = $request->descripcion;
			$categoriaMedicamento->save();
			return Response::json(['message' => 'CategoriaMedicamento Creada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
    }
	
    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$categoriaMedicamento = CategoriaMedicamento::findOrFail($request->id);
			$categoriaMedicamento->nombre = $request->nombre;
			$categoriaMedicamento->descripcion = $request->descripcion;
			$categoriaMedicamento->save();
		return Response::json(['message' => 'CategoriaMedicamento Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $categoriaMedicamento = CategoriaMedicamento::findOrFail($request->id);
        $categoriaMedicamento->estado = '1';
        $categoriaMedicamento->save();
		return Response::json(['message' => 'CategoriaMedicamento Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$categoriaMedicamento = CategoriaMedicamento::findOrFail($request->id);
		$categoriaMedicamento->estado = '0';
		$categoriaMedicamento->save();
		return Response::json(['message' => 'CategoriaMedicamento Desactivado'], 200);
	}
}