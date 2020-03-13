<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Session;

class Cidades extends Model
{
    public $table = 'modulo_cidades';

    public $timestamps = false;

    public function estado() { 
        return $this->hasOne('App\Estados','id','estado_id');
    }


}