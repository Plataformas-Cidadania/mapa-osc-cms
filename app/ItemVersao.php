<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemVersao extends Model
{

    protected $table = 'items_versoes';

    protected $fillable = [
        'imagem', 'arquivo', 'tipo_id', 'integrante_id', 'versao_id', 'cmsuser_id',
    ];
}
