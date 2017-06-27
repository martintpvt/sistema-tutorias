<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    public $fillable = ['Id_Actividad','NombreActividad', 'EspecificarActividad'];
    protected $table = 'actividades';
}
