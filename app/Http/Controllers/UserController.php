<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function getDocentes(Request $request, $Id_Carrera)
    {
        if($request->ajax())
        {
            $docentes = User::getDocentes($Id_Carrera);
            return response()->json($docentes);
        }
    }
}
