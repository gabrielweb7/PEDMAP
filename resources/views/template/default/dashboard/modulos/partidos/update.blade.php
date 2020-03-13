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


                        <div class="form-group col-lg-5">
                            <label for="nome">Nome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="@php echo (!empty(old('nome')))?old('nome'):$registro->nome; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-1">
                            <label for="sigla">Sigla</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="sigla" name="sigla" placeholder="" value="@php echo (!empty(old('sigla')))?old('sigla'):$registro->sigla; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-1">
                            <label for="numero_eleitoral">N°</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="numero_eleitoral" name="numero_eleitoral" placeholder="" value="@php echo (!empty(old('numero_eleitoral')))?old('numero_eleitoral'):$registro->numero_eleitoral; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        
                        <div class="form-group col-lg-5">
                            <label for="presidente_atual">Presidente Atual</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="presidente_atual" name="presidente_atual" placeholder="" value="@php echo (!empty(old('presidente_atual')))?old('presidente_atual'):$registro->presidente_atual; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>
                        
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
