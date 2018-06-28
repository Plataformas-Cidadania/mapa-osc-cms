<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grafico extends Model
{
    protected $table = 'portal.tb_analise';
    protected $primaryKey = 'id_analise';
    public $timestamps = false;

    protected $fillable = [
        'configuracao', 'tipo_grafico', 'titulo', 'legenda', 'legenda_x', 'legenda_y', 'parametros', 'series', 'fontes',
    ];
}
