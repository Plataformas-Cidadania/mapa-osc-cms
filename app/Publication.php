<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'resumida', 'descricao', 'arquivo', 'data', 'cmsuser_id',
    ];
}
