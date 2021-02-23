<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telegram_data_source extends Model
{
    protected $primaryKey = 'data_id';

    protected $fillable = [
        'chat_id',    'chat_type',    'chat_mute'
    ];
}
