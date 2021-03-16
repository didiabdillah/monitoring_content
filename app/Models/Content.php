<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $primaryKey = 'content_id';

    protected $fillable = [
        'content_user_id',    'content_type', 'content_category',   'content_file', 'content_title', 'content_date',   'content_link', 'content_status', 'content_note', 'content_is_present',
    ];


    public function content_file()
    {
        return $this->hasMany('App\Models\Content_file', 'content_file_content_id');
    }

    public function content_link()
    {
        return $this->hasMany('App\Models\Content_link', 'content_link_content_id');
    }

    public function content_history()
    {
        return $this->hasMany('App\Models\Content_history', 'content_history_content_id');
    }
}
