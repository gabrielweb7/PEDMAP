<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;


/* Request Validates */
use App\Http\Requests\modulo\usuarios\CreateValidate;
use App\Http\Requests\modulo\usuarios\UpdateValidate;

/* Essenciais */
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

/* Controllers */
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteTabelasController;

/* Models */
use App\Modulos;

/* mails */
use App\Mail\UsuarioConfirmarConta;


class EquipeController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "equipe";
    
    var $moduloClass = \App\Usuarios::class;
    var $moduloTableColunasSelect = array('id','tipo','nome','sobrenome','email','senha','emailConfirmado','datahora'); /* Colunas Select SQL */

    var $moduloTableColunasSearch = array('email'); /* Colunas Search Like SQL */

    var $moduloTableColunasOrdemFrontEnd = array('id','email','tipo','datahora'); /* Colunas na ordem visivel do FRONT-END */

    var $moduloTableColunaDataHora = 'datahora'; /* Coluna de datahora registro criado SQL */
    var $moduloTableColunaDeleted = 'datahora_deleted'; /* Coluna de deleted SQL */

    /* GET: Listagem dos Registros */
    public function index() {
        $menuItem = $this->getMenuModuloVars();
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.listar', compact("menuItem"));
    }

    /* POST: Listagem AJAX: Alimentar datatable com registros da tb */
    public function listar(Request $request) {

        /* Session */
        $id = Session::get('tipo');

        /* Get Registros */
        $recordsTotalQuery = $this->moduloClass::select($this->moduloTableColunaDeleted);

        /* Permissoes > Get Registros */
        if($id == 1) {
            $recordsTotalQuery->where('tipo','!=','255');
        }else if($id == 100) {
            $recordsTotalQuery->where('tipo','!=','255');
            $recordsTotalQuery->where('tipo','!=','1');
        }
        $recordsTotal = $recordsTotalQuery->whereNull($this->moduloTableColunaDeleted)->count();


        $moduloTableColunasSearch = $this->moduloTableColunasSearch;

        /* Inicia Eloquent */
        $moduloClass = $this->moduloClass::select($this->moduloTableColunasSelect);

        /* Permissoes > Inicia Eloquent*/
        if($id == 1) {
            $moduloClass->where('tipo','!=','255');
        }else if($id == 100) {
            $moduloClass->where('tipo','!=','255');
            $moduloClass->where('tipo','!=','1');
        }

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

            if(Session::get('id') == $registro->id) {
                $loopData[] = '<input type="checkbox" name="selectRegistro" value="" disabled />';
            } else {
                $loopData[] = '<input type="checkbox" name="selectRegistro" value="'.base64_encode($registro->id).'" />';
            }

            $loopData[] = (string)$registro->email;

            #$loopData[] = (string)$registro->descricao;

            #$loopData[] = (string)Str::limit(strip_tags(html_entity_decode($registro->conteudo)),20,'..');

            /* Image */
            /*if(Storage::exists($registro->imagem_src)) {
                $registro->imagem_src = "<a href='".Storage::url($registro->imagem_src)."' id='single_image' data-caption='".$registro->titulo."'>"
                    ."<img src='".Storage::url($registro->imagem_src)."' height='85' width='100' style='object-fit:cover;border: 1px solid #c1c1c1;' />"
                    ."</a>";
            } else {
                $registro->imagem_src = "<img src='https://imgur.com/BRcM28v.png' height='85' width='100' style='object-fit:cover;border: 1px solid #c1c1c1;' />";
            }
            $loopData[] = (string)$registro->imagem_src;
            */

            /* Tipos */
            $tipoTag = "";
            if($registro->tipo == 255) {

                $tipoTag .= "<span class='bxCircle-xs-black'>Developer</span>";

            } else if($registro->tipo == 1) {

                $tipoTag .= "<span class='bxCircle-xs-blue'>Admin</span>";

            } else if($registro->tipo == 100) {
                if($registro->id == Session::get('id')) {
                    $tipoTag .= "<span class='bxCircle-xs-green'>Você</span>";
                } else {
                    $tipoTag .= "<span class='bxCircle-xs-green'>Cliente</span>";
                }
            } else {
                $tipoTag = "<span class='bxCircle-xs-gray'>Nenhum</span>";
            }
            $loopData[] = (string)$tipoTag;

            /* Confirmação de Email */
            $tipoTag = "";
            if($registro->emailConfirmado == 1) {

                $tipoTag .= "<span style=' font-size: 20px; color: #0dcc00;' data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"E-mail Confirmado\"><i class=\"fas fa-check\"></i></span>";

            } else {

                $tipoTag .= "<span style=' font-size: 20px; color: #bdbdbd;' data-toggle=\"tooltip\" data-placement=\"bottom\" title=\"Confirmação Pendente\"><i class=\"fas fa-check\"></i></span>";

            }
            $loopData[] = (string)$tipoTag;


            /* Data da Criação do Registro */
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

        $menuItem = $this->getMenuModuloVars();

        $auth = new AuthController();

        /* Insert Registro */
        $registro = new $this->moduloClass();

        $registro->nome = $request->nome;

        $registro->sobrenome = $request->sobrenome;

        $registro->email = $request->email;
        $registro->senha = null;
        $registro->emailConfirmado = 0;
        $registro->senhaHashRecovery = $auth->criarHashMd5ForEmail();

        /* Se for admin.. deixar colocar tipo escolhido se nao so colocar tipo 101 - filho do cliente */
        $id = Session::get('tipo');

        if($id == 255 or $id == 1) {
            $registro->tipo = $request->tipo;
        } else {
            $registro->tipo = 101;
        }

        $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

        /* Enviar EMail de Confirmacao */
        Mail::to($request->email)->send(new UsuarioConfirmarConta($registro));

        /* Criar tabelas somente se for tipo 100 = cliente */
        if($request->tipo == 100) {

            /* Create tables pessoais */
            ClienteTabelasController::createAllTables($registro->id);

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

        $registro->nome = $request->nome;

        $registro->sobrenome = $request->sobrenome;

        $registro->email = $request->email;

        /* Se for admin.. deixar colocar tipo escolhido se nao so colocar tipo 101 - filho do cliente */
        $id = Session::get('tipo');
        if($id == 255 or $id == 1) {
            $registro->tipo = $request->tipo;
        }

        # $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

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

            $idList = array_map(function($valor) use ($request) {
                return (integer)base64_decode($valor);
            },$request->id);

            $this->moduloClass::whereIn('id', $idList)->where('id','!=',Session::get('id'))->update(['datahora_deleted' => date('Y-m-d H:i:s')]);

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
