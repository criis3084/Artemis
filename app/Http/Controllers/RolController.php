<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;

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
        //insertar datos
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
