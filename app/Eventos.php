<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    
    public $table = 'modulo_eventos';
    protected $dates = ['datahora','dataDoEvento','datahora_update'];
    public $timestamps = false;


}
