<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;

/* Controllers */
use App\Http\Controllers\ClienteTabelasController;

/* Request Validates */
use App\Http\Requests\modulo\blank\CreateValidate;
use App\Http\Requests\modulo\blank\UpdateValidate;

/* Http */
use Illuminate\Http\Request;

/* Support */
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

/* Models */
use App\Modulos;
use App\Noticiascat;

class NoticiasController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "noticias";

    /* Tabela Admin */
    var $tableName = "modulo_noticias";

    /* Model*/
    var $moduloClass = \App\Noticias::class;
    var $model = null; /* Model admin */
    var $clienteModel = null; /* Model Client */

    /* Unir a tabela cliente com Tabela Admin  */
    var $unirTabelaClienteComAdmin = true;

    /* Select > Select */
    var $moduloTableColunasSelect = array('id','tipoTabela','datahora','favorita','retranca','divulgacao','arquivo','imagem_src','bairro','conteudo','resumo','status'); /* Colunas Select SQL */

    /* Select > Search */
    var $moduloTableColunasSearch = array('retranca','divulgacao','resumo'); /* Colunas Search Like SQL */

    /* Select > Front End */
    var $moduloTableColunasOrdemFrontEnd = array('id','retranca','bairro','favorita','status','datahora'); /* Colunas na ordem visivel do FRONT-END */

    /* Coluna de datahora registro criado SQL */
    var $moduloTableColunaDataHora = 'datahora';

    /* Coluna de deleted SQL */
    var $moduloTableColunaDeleted = 'datahora_deleted';

    /* Coluna Visibilidade */
    var $moduloTableColunaVisibilidade = 'visibilidade';

    /* GET: Listagem dos Registros */
    public function index() {
        $menuItem = $this->getMenuModuloVars();
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.listar', compact("menuItem"));
    }

    /* ~~ Functions LISTAR ~~~ */
    public function _isUnido()  {
        if($this->unirTabelaClienteComAdmin) {
            if(Session::get('tipo') == "100" or Session::get('tipo') == "101") {
                return true;
            }
        }
        return false;
    }
    public function _getTableClienteNome()  {
        return ClienteTabelasController::getPrefix(Session::get('id'),$this->tableName);
    }
    public function _getAllRegisters() {
        $this->model = $this->moduloClass::select($this->moduloTableColunasSelect);
        $this->model->whereNull($this->moduloTableColunaDeleted);
        if($this->_isUnido()) {
            $this->clienteModel = new $this->moduloClass();
            $this->clienteModel->table = $this->tableName;
            $this->clienteModel = $this->clienteModel->select($this->moduloTableColunasSelect);
            $this->clienteModel = $this->clienteModel->where("status",'=','1');
            $this->clienteModel = $this->clienteModel->whereNull($this->moduloTableColunaDeleted);
        }
    }
    public function _searchRegisters($searchValue) {
        if(isset($searchValue)) {
            $moduloTableColunasSearch = $this->moduloTableColunasSearch;
            $this->model->where(function($query) use ($moduloTableColunasSearch, $searchValue) {
                foreach($moduloTableColunasSearch as $coluna) {
                    $query->orWhere($coluna,'like','%'.$searchValue.'%');
                }
            });
            if($this->_isUnido()) {
                $this->clienteModel->where(function($query) use ($moduloTableColunasSearch, $searchValue) {
                    foreach($moduloTableColunasSearch as $coluna) {
                        $query->orWhere($coluna,'like','%'.$searchValue.'%');
                    }
                });
            }
        }
    }
    public function _offsetAndLimit($start, $length) {
        if(isset($start) && isset($length)) {
            $this->model->offset($start)->limit($length);
        }
    }
    public function _orderBy($column, $dir) {
        if(isset($column) && isset($dir)) {
            $this->model->orderBy($this->moduloTableColunasOrdemFrontEnd[$column], $dir);
        }
    }
    public function _listagemHtml() {
        $tr = array();
        foreach($this->model->get() as $registro) {
            $td = array();
            $td[] = '<input type="checkbox" name="selectRegistro" value="'.base64_encode($registro->id).'" />';
            $td[] = (string)$registro->retranca;
            $td[] = (string)$registro->bairro;
            $td[] = (string)$registro->importante;
            $td[] = (string)$registro->statusIcon;
            $td[] = (string)$registro->datahora->format("H:i")."<br />".$registro->datahora->format("d/m/Y");
            
            if(Session::get('tipo') == '255' or Session::get('tipo') == '1') { 
                $td[] = (string)'<a href="'.route('modulo-'.$this->moduloNome.'-update', base64_encode($registro->id)).'"><button type="button" class="btn btn-info">Editar</button></a>';
            } else if(Session::get('tipo') == '100' and $registro->status == '0') { 
                $td[] = (string)'<a href="'.route('modulo-'.$this->moduloNome.'-update', base64_encode($registro->id)).'"><button type="button" class="btn btn-info">Editar</button></a>';
            } else if(Session::get('tipo') == '101' and $registro->status == '0') { 
                $td[] = (string)'<a href="'.route('modulo-'.$this->moduloNome.'-update', base64_encode($registro->id)).'"><button type="button" class="btn btn-info">Editar</button></a>';
            } else { 
                $td[] = "";
            }

            $tr[] = $td;
        }
        return $tr;
    }
    public function _unionAll() {
        if($this->_isUnido()) {
            $this->model = $this->model->unionAll($this->clienteModel);
        }
    }
    public function _getModelTotalCount() {
        return $this->model->count();
    }

    /* POST: Listagem AJAX: Alimentar datatable com registros da tb */
    public function listar(Request $request) {

        /* Inicia Eloquent */
        $this->_getAllRegisters();

        /* Total de Registros */
        $recordsTotal = $this->_getModelTotalCount();

        /* Search Mode */
        $this->_searchRegisters($request->search['value']);

        /* Union Client to Admin Table */
        $this->_unionAll();

        /* Offset & Limit */
        $this->_offsetAndLimit($request->start, $request->length);

        /* Order */
        $this->_orderBy($request->order[0]['column'], $request->order[0]['dir']);

        /* Listagem em Html */
        $data = $this->_listagemHtml();

        $jsonData = array();
        $jsonData['draw'] = $request->draw;
        $jsonData['recordsTotal'] = $recordsTotal;
        $jsonData['recordsFiltered'] = $this->_getModelTotalCount();  /* Total de Registros filtrado */
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

        $registro->retranca = $request->retranca;

        $registro->resumo = $request->resumo;

        $registro->divulgacao = $request->divulgacao;

        $registro->bairro = $request->bairro;

        $registro->favorita = $request->favorita;

        if(Session::get('tipo') == '255') { 
            $registro->status = $request->status;
        } else { 
            $registro->status = 0;
        }


        #$registro->categorias_json = json_encode($request->categorias);

        #return dd($request->all());

        /* Upload File Imagem */
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
            $registro->imagem_src = $request->file('imagem')->store('modulo_'.$this->moduloNome.'/imagens');
        } else {
            $registro->imagem_src = "";
        }

        /* Upload File Arquivo */
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $registro->arquivo = $request->file('arquivo')->store('modulo_'.$this->moduloNome.'/arquivos');
        } else {
            $registro->arquivo = "";
        }

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

        /* Se caso imagem cadastrada não existir no servidor.. remover e atualizar */
        if(!empty($registro->imagem_src) && !Storage::exists($registro->imagem_src)){
            $registro->imagem_src = "";
            $registro->save();
        }

        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.update', compact("menuItem", "registro"));
    }

    public function updatePost(UpdateValidate $request) {

        $menuItem = $this->getMenuModuloVars();

        $registro = $this->moduloClass::where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted)->first();

        $registro->retranca = $request->retranca;

        $registro->resumo = $request->resumo;

        $registro->divulgacao = $request->divulgacao;

        $registro->bairro = $request->bairro;

        $registro->favorita = $request->favorita;

        if(Session::get('tipo') == '255') { 
            $registro->status = $request->status;
        } else { 
            $registro->status = 0;
        }

        /* Upload File :: Somente atualizar se tiver nova variavel  */
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {

            /* Caso tenha uma imagem anterior.. verifica se existe e deleta arquivo fisico */
            if(!empty($registro->imagem_src) && Storage::exists($registro->imagem_src)) {
                Storage::delete($registro->imagem_src);
            }

            $registro->imagem_src = $request->file('imagem')->store('modulo_'.$this->moduloNome.'/imagens');
        }

        /* Upload File :: Somente atualizar se tiver nova variavel  */
        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {

            /* Caso tenha uma imagem anterior.. verifica se existe e deleta arquivo fisico */
            if(!empty($registro->arquivo) && Storage::exists($registro->arquivo)) {
                Storage::delete($registro->arquivo);
            }

            $registro->arquivo = $request->file('arquivo')->store('modulo_'.$this->moduloNome.'/arquivos');
        }


        # $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Categorias */
        if($request->categorias > 0) {

            $registro->categorias()->detach();

            foreach($request->categorias as $categoria)
            {
                $registro->categorias()->attach(base64_decode($categoria));
            }
        }

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
        
        $noticiasFiltered = $this->moduloClass::where('bairro','like','%'.$request->bairro.'%')->orderBy('favorita','desc')->orderBy('datahora','desc'); 

        if($noticiasFiltered->count() > 0) { 

            $_html = "";
            foreach($noticiasFiltered->get() as $noticia) { 
                $_html .= "<tr>";
                    $_html .= "<td> {$noticia->retranca} </td>";

                    $noticia->favorita = ($noticia->favorita == 1)?'<i class="fas fa-star starOn" data-toggle="tooltip" data-placement="bottom" title="Importante" data-original-title="Importante"></i>':'<i class="fas fa-star starOff" data-toggle="tooltip" data-placement="bottom" title="Não é importante" data-original-title="Não é importante"></i>';
                    $_html .= "<td style='text-align:center;'> {$noticia->favorita} </td>";
                  
                    $_html .= "<td style='text-align:center;'> {$noticia->datahora->format('d/m/Y')} </td>";

                    /* Mostrar edição somente para cliente ou dev/admin */
                    if($noticia->tipoTabela == "cliente" or (Session::get('tipo') == 255 or Session::get('tipo') == 100)) { 
                        $_html .= "<td style='text-align:center;'> <button type='button' onclick='modalNoticiasUpdateShow({$noticia->id})' class='btn btn-info' style='font-size: 14px; border: 0px; background: #1070d4;'><i class='far fa-edit'></i></button>  </td>";
                    } else { 
                        $_html .= "<td style='text-align:center;'> <button type='button' disabled='disabled' class='btn btn-info' style='font-size: 14px; border: 0px; background: gray;'><i class='fas fa-ban'></i></button>  </td>";
                    }

                $_html .= "</tr>";
            }
            
        } else { 
            $_html = "<td colspan='4' style='padding:20px;text-align:center;'> Nenhum registro encontrado :( </td>";
        }

        return $_html;
    }

}
