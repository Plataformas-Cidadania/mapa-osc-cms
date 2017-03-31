<?php

namespace Cms\Models;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    protected $fillable = [
        'visita_id', 'pagina_id',
    ];
}