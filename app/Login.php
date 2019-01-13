<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    protected $table='logins';
    protected $fillable=['name','email'];
}
