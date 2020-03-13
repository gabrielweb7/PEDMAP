<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\ClienteTabelasController;

class PesquisaInterna extends Model
{
    public $table = 'modulo_pesquisainterna';

    public $rex_pesqXproblema = 'rex_pesquisainternaxproblemabairro';

    public $timestamps = false;
    protected $dates = ['datahora'];


    public function __construct(array $attributes = array())
    {

        if(Session::get('tipo') == 100 or Session::get('tipo') == 101) {

            $tabela = $this->table;
            $tabelaRex = $this->rex_pesqXproblema;

            $this->table = ClienteTabelasController::getPrefix(Session::get('id'), $tabela);
            $this->rex_pesqXproblema = ClienteTabelasController::getPrefix(Session::get('id'), $tabelaRex);

        }

    }

    public function setTable($nameTable) {
        return $this->table = $nameTable;
    }

    public function problemas() {
        return $this->belongsToMany(ProblemasBairro::class, $this->rex_pesqXproblema, 'pesquisa_id', 'problema_id');
    }



}
