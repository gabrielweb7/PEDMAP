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
                            <label for="titulo">Titulo</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="" value="@php echo (!empty(old('titulo')))?old('titulo'):$registro->titulo; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="bairro">Bairro</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="@php echo (!empty(old('bairro')))?old('bairro'):$registro->bairro; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" id="categoria" name="categoria">
                                <option value="bandeiraco" @if( (empty(old('categoria')) && $registro->categoria == "bandeiraco") or (!empty(old('categoria')) && old('categoria') == "bandeiraco") ) selected @endif> Bandeiraço </option>
                                <option value="reuniao" @if( (empty(old('categoria')) && $registro->categoria == "reuniao") or (!empty(old('categoria')) && old('categoria') == "reuniao") ) selected @endif> Reunião </option>
                                <option value="comicio" @if( (empty(old('categoria')) && $registro->categoria == "comicio") or (!empty(old('categoria')) && old('categoria') == "comicio") ) selected @endif> Comício  </option>
                                <option value="caminhada" @if( (empty(old('categoria')) && $registro->categoria == "caminhada") or (!empty(old('categoria')) && old('categoria') == "caminhada") ) selected @endif> Caminhada </option>
                                <option value="carreata" @if( (empty(old('categoria')) && $registro->categoria == "carreata") or (!empty(old('categoria')) && old('categoria') == "carreata") ) selected @endif> Carreata </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="numero_de_participantes">N° de Participantes</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="numero_de_participantes" name="numero_de_participantes" placeholder="" value="@php echo (!empty(old('numero_de_participantes')))?old('numero_de_participantes'):$registro->numero_de_participantes; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="dataDoEvento">Data e Hora</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="datetimerpicker" name="dataDoEvento" placeholder="" value="@php echo (!empty(old('dataDoEvento')))?old('dataDoEvento'):$registro->dataDoEvento->format('d/m/Y H:i'); @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        @if($registro->datahora_update)
                            <div class="form-group col-lg-3">
                                <div> <b>Ultima atualização</b></div>
                                <div> {{ $registro->datahora_update->format('d/m/Y - H:i:s') }}</div>
                            </div>
                        @endif

                        <div class="form-group col-lg-3">
                            <div> <b>Criado em</b></div>
                            <div> {{ $registro->datahora->format('d/m/Y - H:i:s') }}</div>
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
