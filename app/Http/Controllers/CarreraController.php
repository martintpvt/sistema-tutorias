<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Carrera;

class CarreraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::check())
        {
            if(Auth::user()->role == 4)
            {
                $facultadesDB = DB::table('facultades')->get();
                $facultades = array();
                
                foreach($facultadesDB as $key => $value)
                {
                    $facultades[$value->Id_Facultad] = $value->NombreFacultad;
                }
                
                return view('/crearCarrera', ['facultades' => $facultades]);
            }
            else
            {
                return Redirect::route('home');
            }
        }
        else
        {
            return Redirect::route('login');
        }
    }

    public function crearCarrera()
    {
        $data = Input::all();
        
        $rules = array(
            'carrera' => 'required|max:255'
        );
        
        $validator = Validator::make($data, $rules);
        
        if($validator->fails())
            return Redirect::to('/cargarCarreras')->withInput()->withErrors($validator);
        else
        {
            $carreradata = array(
                'Id_Facultad' => Input::get('facultad'),
                'NombreCarrera' => Input::get('carrera')
            );
            
            if(Carrera::create($carreradata))
                return Redirect::route('cargarCarreras');
            else
            {
                Session::flash('error', 'Something went wrong');
                return Redirect::route('cargarCarreras');
            }
        }
    }
}
