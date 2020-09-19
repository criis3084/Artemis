<?php

namespace App\Http\Controllers;

use App\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index(Request $request)
    {
        //mostrar datos
        $respuesta = $request->search;

        return $respuesta;
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
