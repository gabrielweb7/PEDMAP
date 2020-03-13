<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;

/* Request Validates */
use App\Http\Requests\modulo\blank\CreateValidate;
use App\Http\Requests\modulo\blank\UpdateValidate;

/* Essenciais */
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/* Models */
use App\Modulos;

class PesquisaInternaController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "pesquisa-interna";
    var $moduloClass = \App\PesquisaInterna::class;

    var $moduloTableColunasSelect = array('id','estadocivil','escolaridade','faixasalarial','sexo','idade','votariaProporcional','naoVotariaProporcional','votariaMajor','naoVotariaMajor','localizacao','datahora_open','datahora'); /* Colunas Select SQL */

    var $moduloTableColunasSearch = array('estadocivil','escolaridade','faixasalarial','sexo','idade','votariaProporcional','naoVotariaProporcional','votariaMajor','naoVotariaMajor','datahora'); /* Colunas Search Like SQL */

    var $moduloTableColunasOrdemFrontEnd = array('id','id','estadocivil','escolaridade','sexo','idade','datahora'); /* Colunas na ordem visivel do FRONT-END */

    var $moduloTableColunaDataHora = 'datahora'; /* Coluna de datahora registro criado SQL */
    var $moduloTableColunaDeleted = 'datahora_deleted'; /* Coluna de deleted SQL */

    /* GET: Listagem dos Registros */
    public function index() {
        $menuItem = $this->getMenuModuloVars();
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.listar', compact("menuItem"));
    }



    /* POST: Listagem AJAX: Alimentar datatable com registros da tb */
    public function listar(Request $request) {

        /* Get Registros */
        $recordsTotal = $this->moduloClass::select($this->moduloTableColunaDeleted)->whereNull($this->moduloTableColunaDeleted);
        $recordsTotal = $recordsTotal->count();

        $moduloTableColunasSearch = $this->moduloTableColunasSearch;

        /* Inicia Eloquent */
        $moduloClass = $this->moduloClass::select($this->moduloTableColunasSelect);

        /* Somente Coluna Deleted is Null */
        $moduloClass->whereNull($this->moduloTableColunaDeleted);

        /* Search Mode */
        if(isset($request->search['value'])) {

            $requestSearch = $request->search['value'];

            $moduloClass->where(function($query) use ($moduloTableColunasSearch, $requestSearch) {

                foreach($moduloTableColunasSearch as $coluna) {
                    $query->orWhere($coluna,'like','%'.$requestSearch.'%');
                }

            });

            $recordsFiltered = $moduloClass->count();
        } else {
            $recordsFiltered = $recordsTotal;
        }

        /* Offset & Limit */
        if(isset($request->start) && isset($request->length)) {
            $moduloClass->offset($request->start)->limit($request->length);
        }

        /* Order */
        if(isset($request->order[0]['column']) && isset($request->order[0]['dir'])) {
            $moduloClass->orderBy($this->moduloTableColunasOrdemFrontEnd[$request->order[0]['column']], $request->order[0]['dir']);
        }

        #return $moduloClass->toSql();

        /* Recebe Registros */
        $registros = $moduloClass->get();

        $data = array();

        foreach($registros as $registro) {

            $loopData = array();

            /* Monta Array para Datatable receber via ajax */
            $loopData[] = '<input type="checkbox" name="selectRegistro" value="'.base64_encode($registro->id).'" />';

            $loopData[] = (string)"[ <b>ID:</b> {$registro->id} ]";

            $loopData[] = (string)$registro->estadocivil;
            $loopData[] = (string)$registro->escolaridade;
            $loopData[] = (string)$registro->sexo;
            $loopData[] = (string)$registro->idade;

            /* Data */
            $dataHoraBr = date('H:i d/m/Y', strtotime($registro->datahora));
            $dataHoraBrEx = explode(' ', $dataHoraBr);
            $dataFormatado = $dataHoraBrEx[0]." <br /> ".$dataHoraBrEx[1];
            $loopData[] = (string)$dataFormatado;

            /* Actions Buttons*/
            $loopData[] = (string)'<a href="'.route('modulo-'.$this->moduloNome.'-update', base64_encode($registro->id)).'"><button type="button" class="btn btn-info">Editar</button></a>';

            /* End */
            $data[] = $loopData;
        }

        #$registros::get();

        $jsonData = array();

        $jsonData['draw'] = $request->draw;
        $jsonData['recordsTotal'] = $recordsTotal;
        $jsonData['recordsFiltered'] = $recordsFiltered;
        $jsonData['data'] = $data;

        return json_encode($jsonData);

    }

    /* GET && POST Create Registro  */
    public function create(Request $request) {

        $menuItem = $this->getMenuModuloVars();

        /* Chama View */
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.create', compact("menuItem"));
    }

    public function createPost(CreateValidate $request) {

        #var $moduloTableColunasSelect = array('id','estadocivil','escolaridade','faixasalarial','sexo','idade','votariaProporcional','naoVotariaProporcional','votariaMajor','naoVotariaMajor','datahora'); /* Colunas Select SQL */

        $menuItem = $this->getMenuModuloVars();

        /* Insert Registro */
        $registro = new $this->moduloClass();

        $registro->estadocivil = $request->estadocivil;
        $registro->escolaridade = $request->escolaridade;
        $registro->faixasalarial = $request->faixasalarial;
        $registro->sexo = $request->sexo;
        $registro->idade = $request->idade;
        $registro->votariaProporcional = $request->votariaProporcional;
        $registro->naoVotariaProporcional = $request->naoVotariaProporcional;
        $registro->votariaMajor = $request->votariaMajor;
        $registro->naoVotariaMajor = $request->naoVotariaMajor;

        $registro->localizacao = $request->localizacao;

        $registro->datahora_open = $request->datahora_open;
        $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Problemas */
        if($request->problemas > 0) {
            foreach($request->problemas as $problema)
            {
                $registro->problemas()->attach(base64_decode($problema));
            }
        }

        /* Redireciona para index do modulo */
        return redirect()->route($menuItem->route_name);

    }

    /* GET && POST Update Registro */
    public function update(Request $request) {

        $menuItem = $this->getMenuModuloVars();

        /* Recebe Registro da Tabela */
        $registro = $this->moduloClass::select($this->moduloTableColunasSelect)->where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted);

        /* Se caso não encontrar.. redirecionar.. */
        if(!$registro->count()) {
            return redirect()->route('modulo-'.$this->moduloNome.'-index');
        }

        $registro = $registro->first();

        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.update', compact("menuItem", "registro"));
    }

    public function updatePost(UpdateValidate $request) {

        $menuItem = $this->getMenuModuloVars();

        $registro = $this->moduloClass::where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted)->first();

        $registro->estadocivil = $request->estadocivil;
        $registro->escolaridade = $request->escolaridade;
        $registro->faixasalarial = $request->faixasalarial;
        $registro->sexo = $request->sexo;
        $registro->idade = $request->idade;
        $registro->votariaProporcional = $request->votariaProporcional;
        $registro->naoVotariaProporcional = $request->naoVotariaProporcional;
        $registro->votariaMajor = $request->votariaMajor;
        $registro->naoVotariaMajor = $request->naoVotariaMajor;

        $registro->localizacao = $request->localizacao;

        # $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Problemas */
        if($request->problemas > 0) {

            $registro->problemas()->detach();

            foreach($request->problemas as $problema)
            {
                $registro->problemas()->attach(base64_decode($problema));
            }
        }

        return redirect()->route('modulo-'.$this->moduloNome.'-update', $request->id);

    }

    /* POST:: AJAX - Remover Imagem from Registro */
    public function removerImagemFromRegistro(Request $request) {

        /* Busca registro..*/
        $registro = $this->moduloClass::where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted);

        /* Se count der zero.. retornar zero.. */
        if($registro->count() == 0) {
            return 0;
        }

        /* Recebe informacoes do registro da tabela */
        $registro = $registro->first();

        /* Deleta arquivo fisico do servidor */
        Storage::delete($registro->imagem_src);

        /* Limpa valor da coluna do registro selecionado */
        $registro->imagem_src = "";

        /* Salva os dados do registro */
        $registro->save();

        return 1;
    }

    /* GET:: AJAX - delete Cadastros */
    public function deleteAjax(Request $request) {
        if(is_array($request->id)){

            $idList = array_map(function($valor) {
                return (integer)base64_decode($valor);
            },$request->id);

            $this->moduloClass::whereIn('id', $idList)->update(['datahora_deleted' => date('Y-m-d H:i:s')]);

            return 1;
        }
    }

    /* POST:: Deletar somente um */
    public function delete($id) {

        $menuItem = $this->getMenuModuloVars();

        $idDecoded = base64_decode($id);

        $registro = $this->moduloClass::where('id','=',$idDecoded);

        if($registro->count() > 0) {
            $registro->update(['datahora_deleted' => date('Y-m-d H:i:s')]);
        }

        return redirect()->route($menuItem->route_name);
    }

    /* Function: Modulo Variaveis */
    public function getMenuModuloVars() {
        return Modulos::where('modulo_nome', '=', $this->moduloNome)->first();
    }

}
