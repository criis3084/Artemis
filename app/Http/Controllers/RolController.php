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
        //mostrar datos
        $roles = Rol::paginate(10);

        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles
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
