<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Exception;

class RolController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
		$completo = (isset($request->completo)) ? $request->completo : 'false';

		if ($completo == 'false')
		{
			if ($buscar==''){
				$rol = Rol::with('aldea')->orderBy('id', 'desc')->where('estado',1)->paginate(20);
			}
			else{
				$rol = Rol::with('aldea')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		else if ($completo == 'true'){
			if ($buscar==''){
				$rol = Rol::with('aldea')->orderBy('id', 'desc')->paginate(20);
			}
			else{
				$rol = Rol::with('aldea')->where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(20);
			}
		}
		else if($completo == 'select')
		{
			$count = Rol::where('estado', 1)->count();
			$rol = Rol::orderBy('id', 'desc')->where('estado',1)->paginate($count+1);
		}
        return [
            'pagination' => [
                'total'        => $rol->total(),
                'current_page' => $rol->currentPage(),
                'per_page'     => $rol->perPage(),
                'last_page'    => $rol->lastPage(),
                'from'         => $rol->firstItem(),
                'to'           => $rol->lastItem(),
            ],
            'roles' => $rol
		];
    }

    public function store(Request $request)
    {
        try {
			$rol = new Rol();
			$rol->nombre = $request->nombre;
			$rol->save();
			return Response::json(['message' => 'Rol Creado'], 200);
		} catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
		}
    }

    public function update(Request $request)
    {
        //actualizar datos
    }

    public function activar(Request $request)
    {

    }

    public function desactivar(Request $request)
    {

    }
}
