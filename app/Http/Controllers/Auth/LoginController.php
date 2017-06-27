<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function index()
    {
        return view('/auth/login');
    }
    
    public function login()
    {
        $data = Input::all();
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6'
        );
        
        $validator = Validator::make($data, $rules);
        
        if($validator->fails())
            return Redirect::to('/login')->withInput(Input::except('password'))->withErrors($validator);
        else
        {
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password')
            );
            
            if(Auth::validate($userdata))
            {
                if(Auth::attempt($userdata))
                {
                    $role = DB::table('rol')->where('Id_Role', Auth::user()->role)->first();
                    session(['rol' => $role->NombreRole]);
                    return Redirect::route('home');
                }
            }  
            else
            {
                Session::flash('estado', 'Something went wrong');
                return Redirect::route('login');
            }  
        }
    }
    
    public function logout()
    {
        Auth::logout();
        return Redirect::route('login');
    }
}
