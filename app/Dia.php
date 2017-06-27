<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    public $fillable = ['Id_Dia','Dia'];
    protected $table = 'dias';
}
