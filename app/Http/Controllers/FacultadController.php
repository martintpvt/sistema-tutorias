<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

use App\Carrera;

class FacultadController extends Controller
{
    public function getCarreras(Request $request, $id)
    {
        if($request->ajax())
        {
            $carreras = Carrera::getCarreras($id);
            return response()->json($carreras);
        }
    }
}
