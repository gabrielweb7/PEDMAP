<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;


/* Request Validates */
use App\Http\Requests\modulo\estados\CreateValidate;
use App\Http\Requests\modulo\estados\UpdateValidate;

/* Http */
use Illuminate\Http\Request;

use DateTime;

/* Support */
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

/* Models */
use App\Modulos;

class EstadosController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "estados";

    /* Tabela Admin */
    var $tableName = "modulo_estados";

    /* Model*/
    var $moduloClass = \App\Estados::class;
    var $model = null; /* Model admin */

    /* Unir a tabela cliente com Tabela Admin  */
    var $unirTabelaClienteComAdmin = true;

    /* Select > Select */
    var $moduloTableColunasSelect = array('id','nome','sigla','bandeira','datahora'); /* Colunas Select SQL */

    /* Select > Search */
    var $moduloTableColunasSearch = array('nome','sigla','bandeira'); /* Colunas Search Like SQL */

    /* Select > Front End */
    var $moduloTableColunasOrdemFrontEnd = array('id','nome','sigla','bandeira','datahora'); /* Colunas na ordem visivel do FRONT-END */

    /* Coluna de datahora registro criado SQL */
    var $moduloTableColunaDataHora = 'datahora';

    /* Coluna de deleted SQL */
    var $moduloTableColunaDeleted = 'datahora_deleted';

    /* GET: Listagem dos Registros */
    public function index() {
        $menuItem = $this->getMenuModuloVars();
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.listar', compact("menuItem"));
    }


    /* POST: Listagem AJAX: Alimentar datatable com registros da tb */
    public function listar(Request $request) {

         /* Get Registros */
         $recordsTotal = $this->moduloClass::select($this->moduloTableColunaDeleted)->whereNull($this->moduloTableColunaDeleted)->count();

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
 
             $loopData[] = (string)$registro->nome;
 
             $loopData[] = (string)$registro->sigla;
 
             $loopData[] = (string)$registro->imagem();

             $loopData[] = (string)$registro->datahora();
 
             /* Actions Buttons*/
             $loopData[] = (string)'<a href="'.route('modulo-'.$this->moduloNome.'-update', base64_encode($registro->id)).'"><button type="button" class="btn btn-info">Editar</button></a>';
 
             /* End */
             $data[] = $loopData;
         }
 
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

        $menuItem = $this->getMenuModuloVars();

        /* Insert Registro */
        $registro = new $this->moduloClass();

        $registro->nome = $request->nome;

        $registro->sigla = $request->sigla;

        $registro->bandeira = $request->bandeira;

        $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Redireciona para index do modulo */
        return redirect()->route($menuItem->route_name, ['update'=>1]);

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

        $registro->nome = $request->nome;

        $registro->sigla = $request->sigla;

        $registro->bandeira = $request->bandeira;


        $registro->save();

        return redirect()->route('modulo-'.$this->moduloNome.'-update', ['id'=>$request->id,'update'=>1]);

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

    /* POST:: AJAX - Remover Arquivo from Registro */
    public function removerArquivoFromRegistro(Request $request) {

        /* Busca registro..*/
        $registro = $this->moduloClass::where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted);

        /* Se count der zero.. retornar zero.. */
        if($registro->count() == 0) {
            return 0;
        }

        /* Recebe informacoes do registro da tabela */
        $registro = $registro->first();

        /* Deleta arquivo fisico do servidor */
        Storage::delete($registro->arquivo);

        /* Limpa valor da coluna do registro selecionado */
        $registro->arquivo = "";

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

        return redirect()->route($menuItem->route_name, ['deleted'=>1]);
    }

    /* Function: Modulo Variaveis */
    public function getMenuModuloVars() {
        return Modulos::where('modulo_nome', '=', $this->moduloNome)->first();
    }


    // Modal Ajax List Filtered by Id
    public function jsonRegistroById(Request $request) { 
    
        $registerFiltered = $this->moduloClass::with('categorias')->where('id','=',$request->id); 

        if(!$registerFiltered->count()) { return 0; }

        $data = $registerFiltered->first();

        return $data;

    }

   

}
