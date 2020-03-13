<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Session;

use App\Http\Controllers\ClienteTabelasController;

class Noticias extends Model
{
    public $table = 'modulo_noticias';
    public $rexNoticiasXcat = 'rex_noticiasxcat'; /* Tabela de relacionamento de noticias com categoria e vice versa */

    protected $dates = ['datahora'];

    public $timestamps = false;



    protected $appends = ['dataHoraBr'];

    public function getDataHoraBrAttribute()
    {
        return $this->datahora->format('d/m/Y H:i');
    }

    public function __construct()
    {

        if(Session::get('tipo') == 100 or Session::get('tipo') == 101) {

            $tabela = $this->table;
            $tabelaRex = $this->rexNoticiasXcat;

            $this->table = ClienteTabelasController::getPrefix(Session::get('id'), $tabela);
            $this->rexNoticiasXcat = ClienteTabelasController::getPrefix(Session::get('id'), $tabelaRex);

        }

    }

    public function getStatusIconAttribute()
    {
        if($this->status == "1") {
            $retorno = "<i class=\"fas fa-eye starOn\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Público\"></i>";
        } else {
            $retorno = "<i class=\"fas fa-eye starOff\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Privado\"></i>";
        }
        return $retorno;
    }

    public function getImportanteAttribute()
    {
        if($this->favorita == "1") {
            $retorno = "<i class=\"fas fa-star starOn\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Importante\"></i>";
        } else {
            $retorno = "<i class=\"fas fa-star starOff\" data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Não é importante\"></i>";
        }
        return $retorno;
    }

    public function categorias() {
        return $this->belongsToMany(Noticiascat::class, $this->rexNoticiasXcat, 'noticias_id', 'noticiascat_id');
    }

}
