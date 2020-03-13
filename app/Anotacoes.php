<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anotacoes extends Model
{
    
    public $table = 'modulo_anotacoes';
    
    protected $dates = ['datahora'];

    public $timestamps = false;


}
