<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    public $fillable = ['Id_Modulo','Modulo'];
    protected $table = 'modulos';
}
