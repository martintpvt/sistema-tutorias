<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocenteActividad extends Model
{
    public $fillable = ['Id_Docente','Id_Actividad', 'Id_Ubicacion'];
    protected $table = 'docenteactividad';
    
    public $timestamps = false;
}
