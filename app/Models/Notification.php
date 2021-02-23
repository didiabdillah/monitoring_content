<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'notification_user_id',    'notification_detail',    'notification_status',    'notification_date',
    ];
}
