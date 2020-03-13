@extends('template.default.dashboard.layouts.app')

@section('title', $menuItem->nome.' > Atualizar')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')

    <!-- section conteudo -->
    <section class="conteudo">

        <!-- container -->
        <div class="container">

            <!-- secBoxTitle -->
            <div class="secBoxTitle2">
                {{ $menuItem->nome }} > Atualizar
            </div>

            <!-- table actions -->
            <div class="tableActions mg-b-15">
                <!-- addRegistro -->
                <div class="addRegistro"> <a href="{{ route('modulo-'.$menuItem->modulo_nome.'-index')}}"> <button type="button" class="btn btn-primary">Voltar</button> </a> </div>
            </div>

            <!-- div form -->
            <form id="update" class="pd-t-10" action="{{ route('modulo-'.$menuItem->modulo_nome.'-update-post') }}" method="post" enctype="multipart/form-data">

                @csrf

                <!-- Route para Deletar imagem do registro via Ajax -->
                <input type="hidden" id="ajaxRouteDeleteImage" value="{{ route('modulo-'.$menuItem->modulo_nome.'-remove-image') }}" />

                <!-- Route para Deletar Arquivo do registro via Ajax -->
                <input type="hidden" id="ajaxRouteDeleteArquivo" value="{{ route('modulo-'.$menuItem->modulo_nome.'-remove-arquivo') }}" />

                <!-- id do Registro -->
                <input type="hidden" name="id" value="{{ base64_encode($registro->id )}}" />

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>
                                    - {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <script> alert('Validação: Revise as informações do formulário e tente novamente!'); </script>
                @endif

                <!-- boxFormGroup -->
                <div class="boxFormGroup">

                    <!-- boxFormGroupTitle -->
                    {{--<div class="boxFormGroupTitle">  Dados do Registro Blank  </div>--}}

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label for="retranca">Retranca</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="retranca" name="retranca" placeholder="" value="@php echo (!empty(old('retranca')))?old('retranca'):$registro->retranca; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="resumo">Conteudo</label>

                            <!-- TextArea -->
                            <textarea id="summernote" name="resumo" style="display:none;"> @php echo (!empty(old('resumo')))?old('resumo'):$registro->resumo; @endphp </textarea>

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="divulgacao">Divulgação</label>
                            <input type="text" class="form-control" id="divulgacao" name="divulgacao" placeholder="" value="@php echo (!empty(old('divulgacao')))?old('divulgacao'):$registro->divulgacao; @endphp">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="@php echo (!empty(old('bairro')))?old('bairro'):$registro->bairro; @endphp">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="favorita">Importante</label>
                            <select class="form-control" id="favorita" name="favorita">
                                <option value="1" @if( (empty(old('favorita')) && $registro->favorita == "1") or (!empty(old('favorita')) && old('favorita') == 1) ) selected @endif> Sim </option>
                                <option value="0" @if( (empty(old('favorita')) && $registro->favorita == "0") or (!empty(old('favorita')) && old('favorita') == 0) ) selected @endif> Não </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        @php 
                            if(Session::get('tipo') == '255') { 
                        @endphp
                        <div class="form-group col-lg-2">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" @if( (empty(old('status')) && $registro->status == "1") or (!empty(old('status')) && old('status') == 1) ) selected @endif> Publico </option>
                                <option value="0" @if( (empty(old('status')) && $registro->status == "0") or (!empty(old('status')) && old('status') == 0) ) selected @endif> Privado </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>
                        @php
                            }
                        @endphp
                        
                        <div class="form-group col-lg-6">

                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" placeholder="">

                            @if(!empty($registro->imagem_src))
                                <!-- Preview Image and Delete -->
                                <div class="imagePreviewAndDelete">

                                    <!-- img -->
                                    <img src="{{ Helper::assetStorage($registro->imagem_src) }}" />

                                    <!-- actions -->
                                    <div class="actions">
                                        <a href="javascript:void(0);" title="Remover Imagem"> <i class="far fa-trash-alt"></i> </a>
                                    </div>

                                </div>
                            @endif

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->

                        </div>

                        <div class="form-group col-lg-6">
                            <label for="arquivo">Arquivo</label>
                            <input type="file" class="form-control" id="arquivo" name="arquivo" placeholder="">

                            @if(!empty($registro->arquivo) and Helper::assetStorageArquivo($registro->arquivo))
                                <!-- Preview Image and Delete -->
                                    <div class="arquivoPreviewAndDelete">

                                        <!-- img -->
                                        {{--<img src="{{ Helper::assetStorage($registro->arquivo) }}" />--}}

                                        <!-- Link -->
                                        <a href="{{ Helper::assetStorageArquivo($registro->arquivo) }}" target="_blank"> Download do Arquivo </a>

                                        <!-- actions -->
                                        <div class="actions">
                                            <a href="javascript:void(0);" title="Remover Anexo"> <i class="far fa-trash-alt"></i> </a>
                                        </div>

                                    </div>
                            @endif

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">

                            <div> <b>Categorias</b></div>


                            @php
                                $categorias = $registro->categorias;
                                #if(!is_array($categorias)) { $categorias = []; }
                                $arrayCat = [];
                                foreach($categorias as $categoria) {
                                    $arrayCat[] = $categoria->id;
                                }
                            @endphp

                            @foreach(App\Noticiascat::where('visivel','=','1')->whereNull('datahora_deleted')->get() as $categoria)
                                <!-- checkBoxContainer -->
                                    <div class="checkBoxContainer">
                                        <input type="checkbox" value="{{ base64_encode($categoria->id) }}" id="defaultCheck_{{ $categoria->id }}" name="categorias[]" @if(in_array($categoria->id, $arrayCat)) checked @endif>
                                        <label class="form-check-label" for="defaultCheck_{{ $categoria->id }}">
                                            {{ $categoria->categoria }}
                                        </label>
                                    </div>
                            @endforeach

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>


                        <div class="form-group col-lg-12">

                            <div> <b>Criado em</b></div>
                            <div> {{ $registro->datahora->format('H:i:s d/m/Y') }}</div>

                        </div>

                    </div>

                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary" style="float:left;">Atualizar Registro</button>

                <!-- Delete Single Registro -->
                <a id="deleteSingle" href="{{ route('modulo-'.$menuItem->modulo_nome.'-delete', base64_encode($registro->id)) }}" style="float: right;"><button type="button" class="btn btn-danger">Deletar Registro</button></a>

                <!-- Clear Floats -->
                <div class="clear"></div>

            </form>

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection
