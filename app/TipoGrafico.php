<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoGrafico extends Model
{

    protected $table = 'tipos_graficos';
    protected $fillable = [
        'imagem', 'titulo', 'arquivo', 'cmsuser_id',
    ];
}
