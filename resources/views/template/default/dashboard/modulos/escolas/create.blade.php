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

                        <div class="form-group col-lg-6">
                            <label for="categoria">Nome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="{{ old('nome') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">Código</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="cod" name="cod" placeholder="" value="{{ old('cod') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">Administração</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="administracao" name="administracao" placeholder="" value="{{ old('administracao') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        
                        <div class="form-group col-lg-2">
                            <label for="categoria">Zona</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="zona" name="zona" placeholder="" value="{{ old('zona') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Endereço</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="" value="{{ old('endereco') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">N°</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="numero" name="numero" placeholder="" value="{{ old('numero') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">Complemento</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="complemento" name="complemento" placeholder="" value="{{ old('complemento') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">Bairro</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="{{ old('bairro') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">CEP</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="cep" name="cep" placeholder="" value="{{ old('cep') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Telefone</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="" value="{{ old('telefone') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">E-mail</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="email" name="email" placeholder="" value="{{ old('email') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Situação</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="situacao" name="situacao" placeholder="" value="{{ old('situacao') }}">
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
