<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    public $fillable = ['Id_Carrera','Id_Facultad', 'NombreCarrera'];
    protected $table = 'carreras';
    
    public $timestamps = false;

    public static function getCarreras($id)
    {
    	return Carrera::where('Id_Facultad', $id)->get();
    }
}
