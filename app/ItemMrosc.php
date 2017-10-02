<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMrosc extends Model
{

    protected $table = 'items_mroscs';

    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'arquivo', 'modulo_id', 'cmsuser_id',
    ];
}
