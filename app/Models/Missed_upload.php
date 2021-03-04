<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Missed_upload extends Model
{
    protected $primaryKey = 'missed_upload_id';

    protected $fillable = [
        'missed_upload_user_id',    'missed_upload_date',    'missed_upload_total'
    ];
}
