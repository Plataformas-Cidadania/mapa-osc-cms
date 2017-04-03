<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'slug', 'idioma_id', 'cmsuser_id',
    ];
}
