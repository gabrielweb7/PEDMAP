<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidatos extends Model
{
    public $table = "modulo_candidatos"; 
    public $timestamps = false;
    protected $dates = ['datahora','datahora_deleted'];

    public function partido() { 
        return $this->hasOne('App\Partidos','id','partido_id');
    }

}
