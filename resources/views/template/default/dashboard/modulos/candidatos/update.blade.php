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

                     <div class="form-group col-lg-8">
                            <label for="nome">Nome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="@php echo (!empty(old('nome')))?old('nome'):$registro->nome; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="tipo">Cargo</label>
                            <select class="form-control" id="tipo" name="tipo">
                                <option value="vereador" @if( (empty(old('tipo')) && $registro->tipo == "vereador") or (!empty(old('tipo')) && old('tipo') == "vereador") ) selected @endif> Vereador </option>
                                <option value="prefeito" @if( (empty(old('tipo')) && $registro->tipo == "prefeito") or (!empty(old('tipo')) && old('tipo') == "prefeito") ) selected @endif> Prefeito </option>
                                <option value="deputado-estadual" @if( (empty(old('tipo')) && $registro->tipo == "deputado-estadual") or (!empty(old('tipo')) && old('tipo') == "deputado-estadual") ) selected @endif> Deputado Estadual  </option>
                                <option value="deputado-federal" @if( (empty(old('tipo')) && $registro->tipo == "deputado-federal") or (!empty(old('tipo')) && old('tipo') == "deputado-federal") ) selected @endif> Deputado Federal </option>
                                <option value="senador" @if( (empty(old('tipo')) && $registro->tipo == "senador") or (!empty(old('tipo')) && old('tipo') == "senador") ) selected @endif> Senador </option>
                                <option value="governador" @if( (empty(old('tipo')) && $registro->tipo == "governador") or (!empty(old('tipo')) && old('tipo') == "governador") ) selected @endif> Governador </option>
                                <option value="presidente" @if( (empty(old('tipo')) && $registro->tipo == "presidente") or (!empty(old('tipo')) && old('tipo') == "presidente") ) selected @endif> Presidente </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="partido_id">Partido</label>
                            <select class="form-control" id="partido_id" name="partido_id">
                                @foreach(App\Partidos::whereNull('datahora_deleted')->get() as $partido)
                                    @php
                                        $selected = ($partido->id == $registro->partido_id)?'selected':'';
                                    @endphp
                                    <option value="{{ $partido->id }}" {{ $selected }}> {{ $partido->sigla }} - {{ $partido->nome }} </option>
                                @endforeach
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-3">
                            <label>Criado em</label>
                            <div> 
                                <input type="text" class="form-control" id="" name="" disabled placeholder="" value="{{ $registro->datahora->format('d/m/Y - H:i:s') }}">
                            </div>
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
