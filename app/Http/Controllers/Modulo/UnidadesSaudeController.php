<?php

namespace App\Http\Controllers\Modulo;

use App\Http\Controllers\Controller;

/* Request Validates */
use App\Http\Requests\modulo\unidades_saude\CreateValidate;
use App\Http\Requests\modulo\unidades_saude\UpdateValidate;


/* Essenciais */
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/* Models */
use App\Modulos;

class UnidadesSaudeController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "unidades-saude";
    
    var $moduloClass = \App\UnidadesSaude::class;
    var $moduloTableColunasSelect = array('id','nome','estrutura_fisica','adap_defic_fisic_idosos','equipamentos','medicamentos','telefone','endereco','bairro','cidade','cod','datahora'); /* Colunas Select SQL */
    var $moduloTableColunasSearch = array('nome','cod','datahora'); /* Colunas Search Like SQL */

    var $moduloTableColunasOrdemFrontEnd = array('id','nome','cod'); /* Colunas na ordem visivel do FRONT-END */

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

            $loopData[] = (string)$registro->cod;

            #$loopData[] = (string)Str::limit(strip_tags(html_entity_decode($registro->conteudo)),20,'..');

            /* Image */
           /* if(Storage::exists($registro->imagem_src)) {
                $registro->imagem_src = "<a href='".Storage::url($registro->imagem_src)."' id='single_image' data-caption='".$registro->titulo."'>"
                    ."<img src='".Storage::url($registro->imagem_src)."' height='85' width='100' style='object-fit:cover;border: 1px solid #c1c1c1;' />"
                    ."</a>";
            } else {
                $registro->imagem_src = "<img src='https://imgur.com/BRcM28v.png' height='85' width='100' style='object-fit:cover;border: 1px solid #c1c1c1;' />";
            }
            $loopData[] = (string)$registro->imagem_src;
            */

            /* Tags */
            /*$categoriasDecoded = "";
            $registro->categorias_json = json_decode($registro->categorias_json);
            if(is_array($registro->categorias_json)) {
                foreach($registro->categorias_json as $categoria) {
                    $categoriasDecoded .= "<span class='bxCircle-xs-blue'>".$categoria."</span>";
                }
            } else {
                $categoriasDecoded = "<span class='bxCircle-xs-gray'>Nenhum</span>";
            }
            $loopData[] = (string)$categoriasDecoded;
            */

            /* Data */
            #$dataHoraBr = date('H:i d/m/Y', strtotime($registro->datahora));
           # $dataHoraBrEx = explode(' ', $dataHoraBr);
            #$dataFormatado = $dataHoraBrEx[0]." <br /> ".$dataHoraBrEx[1];
            #$loopData[] = (string)$dataFormatado;

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
    public function create() {

        $menuItem = $this->getMenuModuloVars();

        /* Chama View */
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.create', compact("menuItem"));
    }

    public function createPost(CreateValidate $request) {

        $menuItem = $this->getMenuModuloVars();

        /* Insert Registro */
        $registro = new $this->moduloClass();

        $registro->cod = $request->cod;
        $registro->nome = $request->nome;
        $registro->endereco = $request->endereco;
        $registro->bairro = $request->bairro;
        $registro->cidade = $request->cidade;
        $registro->telefone = $request->telefone;
        $registro->estrutura_fisica = $request->estrutura_fisica;
        $registro->adap_defic_fisic_idosos = $request->adap_defic_fisic_idosos;
        $registro->equipamentos = $request->equipamentos;
        $registro->medicamentos = $request->medicamentos;

        $registro->datahora = date('Y-m-d H:i:s');

        $registro->save();

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
//        if(!empty($registro->imagem_src) && !Storage::exists($registro->imagem_src)){
//            $registro->imagem_src = "";
//            $registro->save();
//        }

        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.update', compact("menuItem", "registro"));
    }

    public function updatePost(UpdateValidate $request) {

        $menuItem = $this->getMenuModuloVars();

        $registro = $this->moduloClass::where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted)->first();

        $registro->cod = $request->cod;
        $registro->nome = $request->nome;
        $registro->endereco = $request->endereco;
        $registro->bairro = $request->bairro;
        $registro->cidade = $request->cidade;
        $registro->telefone = $request->telefone;
        $registro->estrutura_fisica = $request->estrutura_fisica;
        $registro->adap_defic_fisic_idosos = $request->adap_defic_fisic_idosos;
        $registro->equipamentos = $request->equipamentos;
        $registro->medicamentos = $request->medicamentos;

        $registro->datahora = date('Y-m-d H:i:s');

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

}
