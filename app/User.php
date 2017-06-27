<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'cedula', 'role', 'area', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function getDocentes($Id_Carrera)
    {
        return User::where([
            ['carrera', $Id_Carrera],
            ['role', 2]
        ])->orWhere([
            ['carrera', $Id_Carrera],
            ['role', 3]
        ])->get();
    }
}
