<?php

namespace App\Http\Controllers;

use App\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class SectorController extends Controller
{
    public function index(Request $request)
    {
		$buscar = $request->buscar;
        $criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';
		$count = Sector::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$sector = Sector::with('aldea')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$sector = Sector::with('aldea')->where([['estado',1],[$criterio, 'like', $buscar]])->orderBy('id', 'desc')->paginate($count);
			}
		}
		else if ($completo == 'true'){
			if ($buscar==''){
				$sector = Sector::with('aldea')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$sector = Sector::with('aldea')->where($criterio, 'like', $buscar)->orderBy('id', 'desc');
			}
		}
		else if($completo == 'select')
		{
			$sector = Sector::orderBy('id', 'desc')->where('estado',1)->paginate($count);
		}
        return[
            'sectores' => $sector
		];
    }

    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$sector = new Sector();
			$sector->nombre = $request->nombre;
			$sector->aldea_id = $request->aldea_id;
			$sector->save();
			return Response::json(['message' => 'Sector Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Sector $sector)
    {
		#if(!$request->ajax())return redirect('/');
		return [
			'id'=> $sector->id,
			'nombre'=> $sector->nombre,
			'aldea_id'=> $sector->aldea_id,
			'aldea_nombre'=> $sector->aldea->nombre,
		];
    }

    public function update(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
		try {
		$sector = Sector::findOrFail($request->id);
		$sector->nombre = $request->nombre;
		$sector->aldea_id = $request->aldea_id;
		$sector->save();
		return Response::json(['message' => 'Sector Actualizada'], 200);
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function activar(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		$sector = Sector::findOrFail($request->id);
		$sector->estado = '1';
		$sector->save();
		return Response::json(['message' => 'Sector Activado'], 200);
	}
    public function desactivar(Request $request)
    {
		//if(!$request->ajax())return redirect('/');
        $sector = Sector::findOrFail($request->id);
        $sector->estado = '0';
		$sector->save();
		return Response::json(['message' => 'Sector Desactivado'], 200);
    }
}
