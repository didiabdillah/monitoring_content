<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $primaryKey = 'holiday_id';

    protected $fillable = [
        'holiday_event', 'holiday_date'
    ];
}
