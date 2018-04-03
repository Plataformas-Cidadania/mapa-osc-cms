<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'tipo_id', 'arquivo', 'url', 'cmsuser_id',
    ];
}
