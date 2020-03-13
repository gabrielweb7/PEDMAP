<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;


/* Request Validates */
use App\Http\Requests\modulo\candidatos\CreateValidate;
use App\Http\Requests\modulo\candidatos\UpdateValidate;

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

class CandidatosController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "candidatos";

    /* Tabela Admin */
    var $tableName = "modulo_candidatos";

    /* Model*/
    var $moduloClass = \App\Candidatos::class;
    var $model = null; /* Model admin */
    var $clienteModel = null; /* Model Client */

    /* Unir a tabela cliente com Tabela Admin  */
    var $unirTabelaClienteComAdmin = true;

    /* Select > Select */
    var $moduloTableColunasSelect = array('id','partido_id','nome','tipo','datahora'); /* Colunas Select SQL */

    /* Select > Search */
    var $moduloTableColunasSearch = array('partido_id','nome'); /* Colunas Search Like SQL */

    /* Select > Front End */
    var $moduloTableColunasOrdemFrontEnd = array('id','nome','partido_id','datahora'); /* Colunas na ordem visivel do FRONT-END */
    
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
             
            if($registro->tipo == "vereador") { $registro->tipo = "Vereador"; }
            else if($registro->tipo == "prefeito") { $registro->tipo = "Prefeito"; }
            else if($registro->tipo == "deputado-estadual") { $registro->tipo = "Deputado Estadual"; }
            else if($registro->tipo == "deputado-federal") { $registro->tipo = "Deputado Federal"; }
            else if($registro->tipo == "senador") { $registro->tipo = "Senador"; }
            else if($registro->tipo == "governador") { $registro->tipo = "Governador"; }
            else if($registro->tipo == "presidente") { $registro->tipo = "Presidente"; }
            else { $registro->tipo = null; }

             $loopData[] = (string)$registro->tipo;

             $loopData[] = (string)$registro->partido->sigla;
 
             $loopData[] = (string)$registro->datahora->format('d/m/Y');
 
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

        $registro->partido_id = $request->partido_id;

        $registro->nome = $request->nome;
        
        $registro->tipo = $request->tipo;

        $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Redireciona para index do modulo */
        return redirect()->route($menuItem->route_name, ['created'=>1]);

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

        $registro->partido_id = $request->partido_id;

        $registro->nome = $request->nome;
        
        $registro->tipo = $request->tipo;

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

        return redirect()->route($menuItem->route_name,['deleted'=>1]);
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

    // jsonRegistrosByLikeBairro
    public function jsonRegistrosByLikeBairro(Request $request) {
        
        $eventos = $this->moduloClass::where('bairro','like','%'.$request->bairro.'%')->orderBy('datahora','desc'); 

        if($eventos->count() > 0) { 

            $_html = "";
            foreach($eventos->get() as $registro) { 
                
                $_html .= "<tr>";

                    if($registro->categoria == "bandeiraco") { $registro->categoria = "Bandeiraço"; }
                    else if($registro->categoria == "reuniao") { $registro->categoria = "Reunião"; }
                    else if($registro->categoria == "comicio") { $registro->categoria = "Comício"; }
                    else if($registro->categoria == "caminhada") { $registro->categoria = "Caminhada"; }
                    else if($registro->categoria == "carreata") { $registro->categoria = "Carreata"; }
                    else { $registro->categoria = "Sem Categoria"; }

                    $_html .= "<td> {$registro->titulo} </td>";
                    $_html .= "<td style='text-align:center;'> {$registro->categoria} </td>";
                    $_html .= "<td style='text-align:center;'> {$registro->numero_de_participantes} </td>";
                    $_html .= "<td style='text-align:center;'> {$registro->dataDoEvento->format('H:i')}<br />{$registro->dataDoEvento->format('d/m/Y')} </td>";
                    $_html .= "<td style='text-align:center;'> <button type='button' onclick=\"alert('Em andamento')\" class='btn btn-info' style='font-size: 14px; border: 0px; background: #1070d4;'><i class='far fa-edit'></i></button>  </td>";      

                $_html .= "</tr>";
            }
            
        } else { 
            $_html = "<td colspan='5' style='padding:20px;text-align:center;'> Nenhum registro encontrado :( </td>";
        }

        return $_html;
    }

}
