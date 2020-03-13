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
                <div class="boxFormGroup" style="    margin-bottom: 17px;">

                    <!-- boxFormGroupTitle -->
                    <div class="boxFormGroupTitle">  Dados pessoais </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="nome">Nome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="{{ old('nome') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="sobrenome">Sobrenome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="" value="{{ old('sobrenome') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                    </div>


                    <!-- boxFormGroupTitle -->
                    <div class="boxFormGroupTitle"> Dados de Acesso <span class="red"> * O usuário vai receber um e-mail para criar sua senha. </span>    </div>

                        <!-- row -->
                        <div class="row">

                            <div class="form-group col-lg-5">
                                <label for="email">E-mail</label>
                                <!-- Class: is-invalid or valid -->
                                <input type="text" class="form-control" id="email" name="email" placeholder="" value="{{ old('email') }}">
                                <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                            </div>

                            <div class="form-group col-lg-2">
                                <label for="tipo">Tipo</label>
                                <!-- Class: is-invalid or valid -->
                                <select class="form-control" id="tipo" name="tipo">
                                    <option value="100" selected>Cliente</option>
                                    <option value="1">Admin</option>
                                </select>
                                <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                            </div>

                        </div>

                    </div>

                <button type="submit" class="btn btn-primary">Criar Registro</button>
            
            </form>

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection
