<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apoio extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'url', 'cmsuser_id',
    ];
}
