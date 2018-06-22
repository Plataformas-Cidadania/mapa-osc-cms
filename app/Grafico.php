<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grafico extends Model
{
    //protected $table = 'graficos';
    protected $table = 'portal.tb_analise';
    protected $primaryKey = 'id_analise';
    public $timestamps = false;
    protected $fillable = [
        //'imagem', 'titulo', 'instituicao', 'area', 'data_vencimento', 'numero_chamada', 'grafico', 'status', 'arquivo', 'cmsuser_id',
        'tipo_grafico', 'titulo', 'legenda', 'legenda_x', 'legenda_y', 'configuracao', 'titulo_colunas',
    ];

    //protected $connection = 'connection-name';
}

