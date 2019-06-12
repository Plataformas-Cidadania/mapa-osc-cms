<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analise extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'resumida', 'descricao', 'arquivo', 'data', 'cmsuser_id',
    ];
}
