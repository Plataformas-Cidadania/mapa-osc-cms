<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoGrafico extends Model
{

    //protected $table = 'tipos_graficos';

    protected $table = 'syst.tb_tipo_grafico';
    protected $primaryKey = 'id_grafico';
    public $timestamps = false;

    protected $fillable = [
       'nome_tipo_grafico',
    ];
}
