<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'url', 'arquivo', 'cmsuser_id',
    ];
}
