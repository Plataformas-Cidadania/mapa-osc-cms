<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'sub_titulo', 'descricao', 'arquivo', 'cmsuser_id',
    ];
}
