<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProblemasBairro extends Model
{
    protected $table = 'modulo_problemasbairro';
    public $timestamps = false;

    public function pesquisas() {
        return $this->belongsToMany(PesquisaInterna::class, 'rex_pesquisainternaxproblemabairro', 'pesquisa_id', 'problema_id');
    }

    public function getVisivelStringAttribute()
    {
        if ($this->visivel == 1) {
            return '<span class=\'bxCircle-xs-blue\'> Ativo </span>';
        } else {
            return '<span class=\'bxCircle-xs-gray\'>Desativado</span>';
        }

    }

}
