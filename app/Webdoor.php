<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webdoor extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'descricao', 'link', 'cmsuser_id',
    ];
}
