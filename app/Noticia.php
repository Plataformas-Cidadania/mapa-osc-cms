<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'slug', 'idioma_id', 'cmsuser_id',
    ];
}
