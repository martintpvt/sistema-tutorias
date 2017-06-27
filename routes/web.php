<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@index']);

Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);

Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@index']);

Route::post('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);

Route::get('forgot-password', ['as' => 'forgot-password', 'uses' => function()
{
    return View::make('/auth/passwords/reset');
}]);

Route::post('forgot-password', ['as' => 'forgot-password', 'uses' => 'Auth\ResetPasswordController@resetPassword']);

Route::get('reset-password', ['as' => 'reset-password', 'uses' => function()
{
    return View::make('/auth/passwords/reset');
}]);

Route::post('reset-password', ['as' => 'reset-password', 'uses' => 'Auth\ResetPasswordController@resetPassword']);

Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('cargarCarreras', ['as' => 'cargarCarreras', 'uses' => 'CarreraController@index']);

Route::post('cargarCarreras', ['as' => 'cargarCarreras', 'uses' => 'CarreraController@crearCarrera']);

Route::get('carreras/{id}', 'FacultadController@getCarreras');

Route::get('horario/{id}', ['as' => 'horario', 'uses' => 'HorarioController@horario']);

Route::get('docentes/{Id_Carrera}', 'UserController@getDocentes');

Route::get('cargarHorario', ['as' => 'cargarHorario', 'uses' => 'HorarioController@index']);

Route::post('cargarHorario', 'HorarioController@cargarHorario');

Route::get('horarioLinks/{id}', ['as' => 'horarioLinks', 'uses' => 'HorarioController@horarioLinks']);

Route::get('cargarActividad/{id_docente}/{dia}/{modulo}', ['as' => 'cargarActividad', 'uses' => 'HorarioController@cargarActividad']);

Route::post('subirActividad', ['as' => 'subirActividad', 'uses' => 'HorarioController@agregarActividad']);

// Route::post('cargarActividad', ['as' => 'cargarActividad', 'uses' => 'HorarioController@cargarActividad']);