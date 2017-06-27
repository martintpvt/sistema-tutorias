<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('guest');
    }
    */

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'cedula' => 'required|min:10|max:10'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'cedula' => $data['cedula'],
            'role' => $data['role'],
            'area' => $data['area'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public function index()
    {
        ini_set('max_execution_time', 1800); //300 seconds = 5 minutes

        $rolesDB = DB::table('rol')->get();
        $facultadesDB = DB::table('facultades')->get();
        
        $roles = array();
        $facultades = array();

        $profesoresDB = DB::table('profesores')->get();

        $cont = 1;

        foreach($profesoresDB as $key => $value)
        {
            if($cont > 1264)
            {
                $userdata = array(
                    'name' => $value->Nombres,
                    'lastname' => $value->Aoellido,
                    'email' => $value->mail,
                    'cedula' => $value->cedula,
                    'role' => 2,
                    'area' => $value->CodigoArea,
                    'password' => $value->cedula
                );

                //print_r($userdata['area']);

                echo $this->create($userdata).'<br>';
            }

            $cont++;
        }
        
        foreach($rolesDB as $key => $value)
        {
            $roles[$value->Id_Role] = $value->NombreRole;
        }
        
        foreach($facultadesDB as $key => $value)
        {
            $facultades[$value->Id_Facultad] = $value->NombreFacultad;
        }
        
        //return view('/auth/register', ['roles' => $roles, 'facultades' => $facultades]);
    }
    
    public function register()
    {
        $data = Input::all();
        $response = $this->registrar($data);

        if($response == 1)
        {
            Session::flash('estado', 'Se creó el usuario correctamente');
            return Redirect::route('register');
        } else if($response == 2) {
            Session::flash('estado', 'Something went wrong');
            return Redirect::route('register');
        } else if($response['codigo'] == 3)
        {
            return Redirect::to('/register')->withInput()->withErrors($response['data']);
        } else if($response == 4)
        {
            Session::flash('estado', 'Ya existe un coordinador para esa carrera');
            return Redirect::to('/register')->withInput();
        }
    }

    protected function registrar($data)
    {
        $rules = array(
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'cedula' => 'required|min:10|max:10|unique:users',
            'role' => 'required',
            'facultad' => 'required',
            'area' => 'required'
        );
        
        $validator = Validator::make($data, $rules);
        
        if($validator->fails())
        {
            return ['codigo' => 3, 'data' => $validator];
        }
        else
        {
            if($data['role'] == 3)
            {
                $coordinador = DB::table('users')->where([
                    ['role', $data['role']],
                    ['carrera', $data['carrera']]
                ])->get();

                if(count($coordinador) > 0)
                {
                    return 4;
                } else {
                    $valido = true;
                }
            } else {
                $valido = true;
            }

            if($valido)
            {
                $userdata = array(
                    'name' => $data['name'],
                    'lastname' => $data['lastname'],
                    'email' => $data['email'],
                    'cedula' => $data['cedula'],
                    'role' => $data['role'],
                    'area' => $data['area'],
                    'password' => $data['cedula']
                );
                
                if($this->create($userdata))
                {
                    return 1;
                }
                else
                {
                    return 2;
                }
            }
        }
    }
}
