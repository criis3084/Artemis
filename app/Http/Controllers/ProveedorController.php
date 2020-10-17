<?php

namespace App\Http\Controllers;

use App\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class ProveedorController extends Controller
{
	public function index(Request $request)
	{
		$buscar = $request->buscar;
		$criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo :'false';
		$count = Proveedor::all()->count();
		if ($completo == 'false')
		{
			if ($buscar==''){
				$proveedor = Proveedor::with('datos')->orderBy('id', 'desc')->where('estado',1)->paginate($count);
			}
			else{
				$proveedor = Proveedor::with('datos')->where([[$criterio, 'like',$buscar],['estado',1]])->orderBy('id', 'desc')->paginate($count);
			}
		} else if ($completo == 'true'){
			if ($buscar==''){
				$proveedor = Proveedor::with('datos')->orderBy('id', 'desc')->paginate($count);
			}
			else{
				$proveedor = Proveedor::with('datos')->where($criterio,'like',$buscar)->orderBy('id', 'desc')->paginate($count);
			}
		}
		return [
			"proveedores"=>$proveedor
		];
	}

	public function store(Request $request)
	{
		try {
			$proveedor = new Proveedor();
			$proveedor->nombre = $request->nombre;
			$proveedor->persona_sin_acceso_id = $request->persona_sin_acceso_id;
			$proveedor->save();
			return Response::json(['message' => 'proveedor Creada'], 200);
			#return ['id' => $nino->id];
		} catch (Exception $e) {
			return Response::json(['message' => $e->getMessage()], 400);
		}
	}

	public function update(Request $request)
	{
		$proveedor = Proveedor::findOrFail($request->id);
		$proveedor->nombre = $request->nombre;
		$proveedor->persona_sin_acceso_id = $request->persona_sin_acceso_id;
		$proveedor->save();
		return Response::json(['message' => 'proveedor Actualizado'], 200);
	}

	public function activar(Request $request)
	{
		$proveedor = Proveedor::findOrFail($request->id);
        $proveedor->estado = '1';
        $proveedor->save();
		return Response::json(['message' => 'proveedor Activado'], 200);
	}

	public function desactivar(Request $request)
	{
		$proveedor = Proveedor::findOrFail($request->id);
        $proveedor->estado = '0';
        $proveedor->save();
		return Response::json(['message' => 'proveedor Desactivado'], 200);
	}
}