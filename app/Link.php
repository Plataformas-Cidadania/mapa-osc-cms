<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'url', 'posicao', 'cmsuser_id',
    ];
}
