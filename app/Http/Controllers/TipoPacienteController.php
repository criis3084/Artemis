<?php

namespace App\Http\Controllers;

use App\TipoPaciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class TipoPacienteController extends Controller
{
    public function index(Request $request)
    {
		#if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
		if ($buscar==''){
			$tipoPaciente = TipoPaciente::orderBy('id', 'desc')->paginate(20);
			#$tipoPaciente = TipoPaciente::leftJoin('sectors', 'sectors.aldea_id', '=', 'aldeas.id')->select('aldeas.nombre as tipoPaciente', 'sectors.nombre as sector')->orderBy('aldeas.id', 'desc')->paginate(20);
		}
		else{
			$tipoPaciente = TipoPaciente::where('nombre', 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
		}
		
        return [
            'pagination' => [
                'total'        => $tipoPaciente->total(),
                'current_page' => $tipoPaciente->currentPage(),
                'per_page'     => $tipoPaciente->perPage(),
                'last_page'    => $tipoPaciente->lastPage(),
                'from'         => $tipoPaciente->firstItem(),
                'to'           => $tipoPaciente->lastItem(),
            ],
            'tipoPacientes' => $tipoPaciente
		];
    }
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$tipoPaciente = new TipoPaciente();
			$tipoPaciente->nombre = $request->nombre;
			$tipoPaciente->save();
			return Response::json(['message' => 'TipoPaciente Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
		$tipoPaciente = TipoPaciente::findOrFail($request->id);
		$tipoPaciente->nombre = $request->nombre;
		$tipoPaciente->save();
		return Response::json(['message' => 'TipoPaciente Actualizado'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}
	public function activar(Request $request)
	{
        #if(!$request->ajax())return redirect('/');
        $tipoPaciente = TipoPaciente::findOrFail($request->id);
        $tipoPaciente->estado = '1';
        $tipoPaciente->save();
		return Response::json(['message' => 'TipoPaciente Activado'], 200);
	}
	
	public function desactivar(Request $request)
	{
		#if(!$request->ajax())return redirect('/');
		$tipoPaciente = TipoPaciente::findOrFail($request->id);
		$tipoPaciente->estado = '0';
		$tipoPaciente->save();
		return Response::json(['message' => 'TipoPaciente Desactivado'], 200);
	}
}