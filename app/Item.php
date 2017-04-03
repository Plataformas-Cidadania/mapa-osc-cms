<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'modulo_id', 'idioma_id', 'cmsuser_id',
    ];
}
