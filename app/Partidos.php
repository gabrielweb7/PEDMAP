<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partidos extends Model
{
    public $table = "modulo_partidos"; 
    public $timestamps = false;
    protected $dates = ['datahora','datahora_deleted'];
}
