<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    public $fillable = ['Id_Facultad','NombreFacultad'];
    protected $table = 'facultades';
}
