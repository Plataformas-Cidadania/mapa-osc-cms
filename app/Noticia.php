<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'resumida', 'descricao', 'arquivo', 'slug', 'data', 'idioma_id', 'cmsuser_id',
    ];
}
