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
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Fotografia::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$fotografia = Fotografia::orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$fotografia = Fotografia::where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$fotografia = Fotografia::orderBy('id', 'desc')->paginate($count);
			}
			else{
				$fotografia = Fotografia::where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"fotografias"=>$fotografia
		];
	}
	
    public function store(Request $request)
    {
		#if(!$request->ajax())return redirect('/');
        try {
			$fotografia = new Fotografia();
			$fotografia->ruta = $request->ruta;
			$fotografia->descripcion = $request->descripcion;
			$fotografia->titulo = $request->titulo;
			$fotografia->save();
			return Response::json(['message' => 'Fotografia Subida'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function show(Fotografia $fotografia)
    {
		return [
			'id'=> $fotografia->id,
			'ruta'=> $fotografia->ruta,
			'titulo'=> $fotografia->titulo,
			'descripcion'=> $fotografia->descripcion
		];
    }

    public function update(Request $request)
    {
		$fotografia = Fotografia::findOrFail($request->id);
		$fotografia->ruta = $request->ruta;
		$fotografia->titulo = $request->titulo;
		$fotografia->descripcion = $request->descripcion;
		$fotografia->save();
		return Response::json(['message' => 'Fotografía Actualizada'], 200);
        //
    }

	public function activar(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		$fotografia = Fotografia::findOrFail($request->id);
		$fotografia->estado = '1';
		$fotografia->save();
		return Response::json(['message' => 'Fotografía Activada'], 200);
	}
	public function desactivar(Request $request)
	{
		//if(!$request->ajax())return redirect('/');
		$fotografia = Fotografia::findOrFail($request->id);
		$fotografia->estado = '0';
		$fotografia->save();
		return Response::json(['message' => 'Fotografía Desactivada'], 200);
	}
}
