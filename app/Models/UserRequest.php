<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];
}
