<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edital extends Model
{
    //protected $table = 'editais';
    protected $table = 'portal.tb_edital';
    protected $primaryKey = 'id_edital';
    public $timestamps = false;
    protected $fillable = [
        //'imagem', 'titulo', 'instituicao', 'area', 'data_vencimento', 'numero_chamada', 'edital', 'status', 'arquivo', 'cmsuser_id',
        'tx_orgao', 'tx_programa', 'tx_area_interesse_edital', 'dt_vencimento', 'tx_link_edital', 'tx_numero_chamada',
    ];

    //protected $connection = 'connection-name';
}

