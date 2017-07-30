<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edital extends Model
{
    protected $table = 'editais';
    protected $fillable = [
        'imagem', 'titulo', 'instituicao', 'area', 'data_vencimento', 'numero_chamada', 'edital', 'status', 'arquivo', 'cmsuser_id',
    ];
}
