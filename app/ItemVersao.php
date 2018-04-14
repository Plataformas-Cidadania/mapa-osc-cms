<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemVersao extends Model
{

    protected $table = 'items_versoes';

    protected $fillable = [
        'imagem', 'titulo', 'arquivo', 'url', 'tipo_id', 'versao_id', 'cmsuser_id',
    ];
}
