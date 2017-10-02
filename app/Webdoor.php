<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Webdoor extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'resumida', 'descricao', 'link', 'cmsuser_id',
    ];
}
