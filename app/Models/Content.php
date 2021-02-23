<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $primaryKey = 'content_id';

    protected $fillable = [
        'content_user_id',    'content_type',    'content_file',    'content_link',
    ];
}
