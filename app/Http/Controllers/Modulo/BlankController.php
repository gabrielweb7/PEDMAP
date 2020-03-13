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
use App\Menu;

class BlankController extends Controller
{

    /* Configurações do Modulo */
    var $moduloNome = "blank";
    var $moduloClass = \App\Blank::class;
    var $moduloTableColunasSelect = array('id','titulo','descricao','conteudo','imagem_src','categorias_json','datahora'); /* Colunas Select SQL */
    var $moduloTableColunasSearch = array('titulo','descricao','categorias_json','datahora'); /* Colunas Search Like SQL */
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
        	$moduloClass->orderBy($this->moduloTableColunasSelect[$request->order[0]['column']], $request->order[0]['dir']);
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

            $loopData[] = (string)$registro->descricao;

            $loopData[] = (string)Str::limit(strip_tags(html_entity_decode($registro->conteudo)),20,'..');

            /* Image */
            if(Storage::exists($registro->imagem_src)) {
                $registro->imagem_src = "<a href='".Storage::url($registro->imagem_src)."' id='single_image' data-caption='".$registro->titulo."'>"
                                        ."<img src='".Storage::url($registro->imagem_src)."' height='85' width='100' style='object-fit:cover;border: 1px solid #c1c1c1;' />"
                                        ."</a>";
            } else {
                $registro->imagem_src = "<img src='https://imgur.com/BRcM28v.png' height='85' width='100' style='object-fit:cover;border: 1px solid #c1c1c1;' />";
            }
            $loopData[] = (string)$registro->imagem_src;

            /* Tags */
            $categoriasDecoded = "";
            $registro->categorias_json = json_decode($registro->categorias_json);
            if(is_array($registro->categorias_json)) {
                foreach($registro->categorias_json as $categoria) {
                    $categoriasDecoded .= "<span class='bxCircle-xs-blue'>".$categoria."</span>";
                }
            } else {
                $categoriasDecoded = "<span class='bxCircle-xs-gray'>Nenhum</span>";
            }
            $loopData[] = (string)$categoriasDecoded;

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
    public function create(CreateValidate $request) {
        
        $menuItem = $this->getMenuModuloVars();

        /* Se caso for POST */
        if($request->method() == "POST") {

            /* Insert Registro */
            $registro = new $this->moduloClass();

            $registro->titulo = $request->titulo;
            $registro->descricao = $request->descricao;
            $registro->conteudo = $request->conteudo;
            $registro->categorias_json = json_encode($request->categorias);

            /* Upload File */
            if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {
                $registro->imagem_src = $request->file('imagem')->store('modulo_'.$this->moduloNome);
            } else {
                $registro->imagem_src = "";
            }

            $registro->datahora = date('Y-m-d H:i:s');

            $registro->save();
            
            /* Redireciona para index do modulo */
            return redirect()->route($menuItem->route_name);
        }

        /* Se caso for GET */

        /* Chama View */
        return view('template.default.dashboard.modulos.'.$this->moduloNome.'.create', compact("menuItem"));
    }

    /* GET && POST Update Registro */
    public function update(UpdateValidate $request) {

        $menuItem = $this->getMenuModuloVars();

        if($request->method() == "POST") {

            $registro = $this->moduloClass::where('id','=',base64_decode($request->id))->whereNull($this->moduloTableColunaDeleted)->first();

            $registro->titulo = $request->titulo;
            $registro->descricao = $request->descricao;
            $registro->conteudo = $request->conteudo;
            $registro->categorias_json = json_encode($request->categorias);

            /* Upload File :: Somente atualizar se tiver nova variavel  */
            if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {

                /* Caso tenha uma imagem anterior.. verifica se existe e deleta arquivo fisico */
                if(!empty($registro->imagem_src) && Storage::exists($registro->imagem_src)) {
                    Storage::delete($registro->imagem_src);
                }

                $registro->imagem_src = $request->file('imagem')->store('modulo_'.$this->moduloNome);
            }

            # $registro->datahora = date('Y-m-d H:i:s');

            $registro->save();

            return redirect()->route('modulo-'.$this->moduloNome.'-update', $request->id);
        }

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
        return Menu::where('modulo_nome', '=', $this->moduloNome)->first();
    }

}
