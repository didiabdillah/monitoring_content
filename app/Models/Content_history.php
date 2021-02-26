<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content_history extends Model
{
    protected $table = 'content_histories';
    protected $primaryKey = 'content_history_id';

    protected $fillable = [
        'content_history_content_id',    'content_history_note',    'content_history_status',
    ];

    public function content()
    {
        return $this->belongsTo('App\Models\Content', 'content_history_content_id');
    }
}
