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

                        <div class="form-group col-lg-4">
                            <label for="categoria">Telefone</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="" value="{{ old('telefone') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Endereço</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="" value="{{ old('endereco') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Bairro</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="{{ old('bairro') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Cidade</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="cidade" name="cidade" placeholder="" value="{{ old('cidade') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>
                       

                        <div class="form-group col-lg-6">
                            <label for="categoria">Estrutura Física</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="estrutura_fisica" name="estrutura_fisica" placeholder="" value="{{ old('estrutura_fisica') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="categoria">Acessibilidade</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="adap_defic_fisic_idosos" name="adap_defic_fisic_idosos" placeholder="" value="{{ old('adap_defic_fisic_idosos') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="categoria">Equipamentos</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="equipamentos" name="equipamentos" placeholder="" value="{{ old('equipamentos') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-6">
                            <label for="categoria">Medicamentos</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="medicamentos" name="medicamentos" placeholder="" value="{{ old('medicamentos') }}">
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
