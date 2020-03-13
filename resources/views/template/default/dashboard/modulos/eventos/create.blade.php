@extends('template.default.dashboard.layouts.app')

@section('title', $menuItem->nome.' > Novo')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')

    <!-- section conteudo -->
    <section class="conteudo">

        <!-- container -->
        <div class="container">

            <!-- secBoxTitle -->
            <div class="secBoxTitle2">
                {{ $menuItem->nome }} > Novo
            </div>

            <!-- table actions -->
            <div class="tableActions mg-b-15">
                <!-- addRegistro -->
                <div class="addRegistro"> <a href="{{ route('modulo-'.$menuItem->modulo_nome.'-index')}}"> <button type="button" class="btn btn-primary">Voltar</button> </a> </div>
            </div>


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
            @endif

            <!-- div form -->
            <form id="create" class="pd-t-10" action="{{ route('modulo-'.$menuItem->modulo_nome.'-create-post') }}" method="post" enctype="multipart/form-data">
                
                @csrf

                <!-- boxFormGroup -->
                <div class="boxFormGroup"> 

                    <!-- boxFormGroupTitle -->
                    {{--<div class="boxFormGroupTitle">  Dados do Registro Blank  </div>--}}

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-12">
                            <label for="titulo">Titulo</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="" value="{{ old('titulo') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="bairro">Bairro</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="{{ old('bairro') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="categoria">Categoria</label>
                            <select class="form-control" id="categoria" name="categoria">
                                <option value="bandeiraco" @if(old('categoria') == "bandeiraco") selected @endif> Bandeiraço </option>
                                <option value="reuniao" @if(old('categoria') == "reuniao") selected @endif> Reunião </option>
                                <option value="comicio" @if(old('categoria') == "comicio") selected @endif> Comício  </option>
                                <option value="caminhada" @if(old('categoria') == "caminhada") selected @endif> Caminhada </option>
                                <option value="carreata" @if(old('categoria') == "carreata") selected @endif> Carreata </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="numero_de_participantes">N° de Participantes</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="numero_de_participantes" name="numero_de_participantes" placeholder="" value="{{ old('numero_de_participantes') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="dataDoEvento">Data e Hora</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="datetimerpicker" name="dataDoEvento" placeholder="" value="{{ old('dataDoEvento') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                    </div>

                </div>
                
                <!--
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                -->

                <button type="submit" class="btn btn-primary">Criar Registro</button>
            
            </form>

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection
