<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'sigla', 'cmsuser_id',
    ];
}
