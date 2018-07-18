<?php

namespace Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    protected $fillable = [
        'visitante_id', 'pagina_id',
    ];
}