<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = [
        'titulo', 'slug', 'cmsuser_id',
    ];
}
