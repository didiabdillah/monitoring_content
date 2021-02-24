<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id', 'user_name',    'user_email',    'user_password',    'user_daily_target',    'user_phone',    'user_role',    'user_image',
    ];
}
