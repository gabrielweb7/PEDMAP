<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Session;

class Estados extends Model
{
    public $table = 'modulo_estados';

    public $timestamps = false;

    protected $dates = ['datahora','datahora_deleted'];

    public function imagem() { 

        if(is_null($this->bandeira) or empty($this->bandeira) or !isset($this->bandeira)) { 
            
            return '<img src="https://imgur.com/ij1ZYSr.png" style="width:42px; max-height:30px;object-fit:cover;border:1px solid #ccc;">';

        }

        return '<img src="'.$this->bandeira.'" style="height:30px;">';

    }

    public function datahora() { 

        if(is_null($this->datahora) or empty($this->datahora) or !isset($this->datahora)) { 
            
            return '~';

        }

        return $this->datahora->format('d/m/Y').' '.$this->datahora->format('H:i');

    }

}