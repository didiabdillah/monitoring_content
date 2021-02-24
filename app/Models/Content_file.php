<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content_file extends Model
{
    protected $primaryKey = 'content_file_id';

    protected $fillable = [
        'content_file_content_id',   'content_file_original_name',    'content_file_hash_name',    'content_file_base_name',    'content_file_extension',
    ];

    public function content()
    {
        return $this->belongsTo('App\Models\Content', 'content_file_content_id');
    }
}
