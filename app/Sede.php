<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    public $fillable = ['Id_Sede','NombreSede'];
    protected $table = 'sedes';
}
