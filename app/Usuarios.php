<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';

    protected $dates = ['datahora'];

    public $timestamps = false;

    public function cidade() { 
        return $this->hasOne('App\Cidades','id','cidade_id');
    }
    
}
