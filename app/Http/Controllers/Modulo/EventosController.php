<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;

/* Controllers */
use App\Http\Controllers\ClienteTabelasController;

/* Request Validates */
use App\Http\Requests\modulo\eventos\CreateValidate;
use App\Http\Requests\modulo\eventos\UpdateValidate;

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

class EventosController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "eventos";

    /* Tabela Admin */
    var $tableName = "modulo_eventos";

    /* Model*/
    var $moduloClass = \App\Eventos::class;
    var $model = null; /* Model admin */
    var $clienteModel = null; /* Model Client */

    /* Unir a tabela cliente com Tabela Admin  */
    var $unirTabelaClienteComAdmin = true;

    /* Select > Select */
    var $moduloTableColunasSelect = array('id','titulo','categoria','numero_de_participantes','bairro','dataDoEvento','datahora_update','datahora'); /* Colunas Select SQL */

    /* Select > Search */
    var $moduloTableColunasSearch = array('titulo','categoria','bairro'); /* Colunas Search Like SQL */

    /* Select > Front End */
    var $moduloTableColunasOrdemFrontEnd = array('id','titulo','categoria','numero_de_participantes','bairro','dataDoEvento'); /* Colunas na ordem visivel do FRONT-END */

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
 
             $loopData[] = (string)$registro->titulo;
 
             $loopData[] = (string)$registro->categoria;
 
             $loopData[] = (string)$registro->numero_de_participantes;

             $loopData[] = (string)$registro->bairro;
 
             $loopData[] = (string)$registro->dataDoEvento->format('H:i').'<br/>'.$registro->dataDoEvento->format('d/m/Y');
 
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

        $registro->titulo = $request->titulo;

        $registro->categoria = $request->categoria;

        $registro->numero_de_participantes = ($request->numero_de_participantes)?$request->numero_de_participantes:0;

        $registro->bairro = $request->bairro;

        /* Convert Date and time Br to MYSQL */
        $dataDoEventoEx = explode(' ', $request->dataDoEvento);
        $onlyDateEx = explode('/',$dataDoEventoEx[0]);
        $dataInMysql = "{$onlyDateEx[2]}-{$onlyDateEx[1]}-{$onlyDateEx[0]} {$dataDoEventoEx[1]}:00";

        $registro->dataDoEvento = $dataInMysql;

        $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Categorias */
        if($request->categorias > 0) {
            foreach($request->categorias as $categoria)
            {
                $registro->categorias()->attach(base64_decode($categoria));
            }
        }

        /* Redireciona para index do modulo */
        return redirect()->route($menuItem->route_name, ['created' => true]);

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

        $registro->titulo = $request->titulo;

        $registro->categoria = $request->categoria;

        $registro->numero_de_participantes = ($request->numero_de_participantes)?$request->numero_de_participantes:0;

        $registro->bairro = $request->bairro;

        /* Convert Date and time Br to MYSQL */
        $dataDoEventoEx = explode(' ', $request->dataDoEvento);
        $onlyDateEx = explode('/',$dataDoEventoEx[0]);
        $dataInMysql = "{$onlyDateEx[2]}-{$onlyDateEx[1]}-{$onlyDateEx[0]} {$dataDoEventoEx[1]}:00";

        $registro->dataDoEvento = $dataInMysql;

        $registro->datahora_update = date('Y-m-d H:i:s');

        $registro->save();

        return redirect()->route('modulo-'.$this->moduloNome.'-update', ['id' => $request->id, 'update' => true]);

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

        return redirect()->route($menuItem->route_name, ['deleted' => true]);
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
