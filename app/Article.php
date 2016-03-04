<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $fillable = [
        'title',
        'introduction',
        'content',
        'published_at'
    ];
}
