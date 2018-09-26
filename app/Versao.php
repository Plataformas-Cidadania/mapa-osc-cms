<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Versao extends Model
{

    protected $table = 'versoes';

    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'posicao', 'cmsuser_id',
    ];
}
