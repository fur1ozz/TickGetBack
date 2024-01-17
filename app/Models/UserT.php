<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserT extends Model
{
    protected $table = 'usersT';

    protected $fillable = ['email', 'password_hash', 'username', 'full_name', 'access', 'token'];

}


