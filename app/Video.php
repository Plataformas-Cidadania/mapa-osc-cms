<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'titulo', 'link_video', 'cmsuser_id',
    ];
}
