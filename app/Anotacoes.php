<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anotacoes extends Model
{
    
    public $table = 'modulo_anotacoes';
    
    protected $dates = ['datahora'];

    public $timestamps = false;


    public function datahora() { 
        if(!empty($this->datahora) and isset($this->datahora)) { 
            return $this->datahora->format('d/m/Y').' '.$this->datahora->format('H:i');
        } 
        return '';
    }

    public function bairro() { 
        return $this->hasOne('App\BairrosRegioes','id','bairro_id')->first();
    }

    

}
