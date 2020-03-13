<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresidentesBairro extends Model
{
    
    public $table = "modulo_presidentesDoBairro"; 
    public $timestamps = false;
    protected $dates = ['datahora','datahora_deleted'];

    public function bairro() { 
        return $this->hasOne('App\BairrosRegioes','id','bairro_id');
    }

    

}
