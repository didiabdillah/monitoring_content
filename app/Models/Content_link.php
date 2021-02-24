<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content_link extends Model
{
    protected $primaryKey = 'content_link_id';

    protected $fillable = [
        'content_link_content_id',   'content_link_url',
    ];

    public function content()
    {
        return $this->belongsTo('App\Models\Content', 'content_link_content_id');
    }
}
