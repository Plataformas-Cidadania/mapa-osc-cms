<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mrosc extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'subtitulo', 'descricao', 'arquivo', 'slug', 'posicao', 'idioma_id', 'cmsuser_id',
    ];
}
