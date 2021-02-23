<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'setting_api_wa', 'setting_smtp_host', 'setting_smtp_port', 'setting_smtp_user', 'setting_smtp_password', 'setting_logo', 'setting_favicon'
    ];
}
