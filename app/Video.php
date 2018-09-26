<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'imagem', 'titulo', 'data', 'resumida', 'descricao', 'link_video', 'cmsuser_id',
    ];
}
