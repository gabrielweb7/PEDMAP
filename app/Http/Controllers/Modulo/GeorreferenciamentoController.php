<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;

/* Essenciais */
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/* Models */
use App\Modulos;
use App\BairrosRegioes;
use App\Escolas;
use App\UnidadesSaude;
use App\Indicadores;

use DB;

class GeorreferenciamentoController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "georreferenciamento";

    /* GET: Listagem dos Registros */
    public function index() {
        $menuItem = $this->getMenuModuloVars();
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.mapa', compact("menuItem"));
    }

    /* Function: Modulo Variaveis */
    public function getMenuModuloVars() {
        return Modulos::where('modulo_nome', '=', $this->moduloNome)->first();
    }

    public function ajaxGetInfowindowGeral(Request $request) { 
        
        
        $html = "<b>Presidente do Bairro:</b>  Nome Completo  <br />";
        
        $db = DB::table('bairrobd')->where('bairro','like','%'.$request->bairro.'%')->first();

        if($db) { 
            $html .= $db->texto;
        }

        return $html;
    }

    public function getInfoWindowRegiao(Request $request) { 

        $_html = "<div class='infoWindow'>";

        $bairroRegioes = BairrosRegioes::where('id','=',$request->regiaoId)->first();

        /* Title Box */
        $_html .= "
            <div class='titleBox'>
                <b>Bairro:</b> {$bairroRegioes->bairro}
            </div>
            ";

        /* Eleitores */
        $_html .= " 
            <div class='lineBox'>
                <b>Eleitores:</b>  <span style='color:red;'>Nenhum</span>
            </div>";
            
        /* Indicadores */
        $indicadores = Indicadores::where('bairro','like','%'.$bairroRegioes->bairro.'%')->orderBy('id','desc')->get();
        
        if($indicadores->count() > 0) { 
            
            foreach($indicadores as $indicador) { 
                $_html .= "<div class='lineBox'>
                                <b>{$indicador->indicador}:</b> {$indicador->indice}
                           </div>";
            }
            $_html .= "<div class='lineBoxBgSmallGray'>
                <span style='color:gray;font-size:12px;'>Fonte: IBGE/2010</span>
            </div>";
        }
        
        /* Escolas Publicas */
        $escolas = Escolas::where('bairro','like','%'.$bairroRegioes->bairro.'%')->where('administracao','!=','privada')->get();

        $_html .= "<div class='lineBox'>";    
            
            $_html .= "<b>Escolas Municipais: </b>";

            if($escolas->count() == 0) { 
                $_html .= "<span style='color:red;'>Nenhum</span>";
            } else { 

                $_html .= "<ul>";

                foreach($escolas as $escola) { 
                    $_html .= "<li>{$escola->nome}</li>";
                }

                $_html .= "</ul>";

            }

        $_html .= "</div>";
        
        /* Unidades de Saude */
        $unidadesSaude = UnidadesSaude::where('bairro','like','%'.$bairroRegioes->bairro.'%')->get();

        $_html .= "<div class='lineBox'>";    
            
            $_html .= "<b>Unidades de Saúde: </b>";

            if($unidadesSaude->count() == 0) { 
                $_html .= "<span style='color:red;'>Nenhum</span>";
            } else { 

                $_html .= "<ul>";

                foreach($unidadesSaude as $unidade) { 
                    $_html .= "<li>{$unidade->nome}</li>";
                }

                $_html .= "</ul>";

            }

        $_html .= "</div>";


        /* MenuBotton */
        $_html .= "<div class='menuBottom'>        
            <div class='row'>
                <div class='col'><a href='#' onclick=\"modalGeralListShow('{$bairroRegioes->bairro}')\"> Geral </a></div>
                <div class='col'><a href='#' onclick=\"modalNoticiasListShow('{$bairroRegioes->bairro}')\"> Noticias </a></div>
                <div class='col'><a href='#' onclick=\"modalAnotacoesListShow('{$bairroRegioes->bairro}')\"> Anotações </a></div>
                <div class='col'><a href='#' onclick=\"modalEventsListShow('{$bairroRegioes->bairro}')\"> Eventos </a></div>
                <div class='col'><a href='#' onclick=\"modalGraficosShow('{$bairroRegioes->bairro}')\"> Gráficos </a></div>
            </div>
        </div>";


        $_html .= "</div> ";

        return $_html;
    }

}
