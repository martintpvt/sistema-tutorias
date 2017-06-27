<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    public $fillable = ['Id_Ubicacion','Id_Dia', 'Id_Modulo', 'Id_Sede', 'Aula'];
    protected $table = 'ubicaciones';
    
    public $timestamps = false;
}
