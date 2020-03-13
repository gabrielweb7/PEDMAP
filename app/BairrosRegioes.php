<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Session;

class BairrosRegioes extends Model
{
    //public $table = 'bairros_regioes';
    public $table = 'modulo_bairros_e_regioes';

    protected $dates = ["datahora_deleted"];
    
    public $timestamps = false;

    public function cidade() { 
        return $this->hasOne('App\Cidades','id','cidade_id');
    }

}