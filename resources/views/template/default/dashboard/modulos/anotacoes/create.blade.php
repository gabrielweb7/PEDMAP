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
                            <label for="nome">Anotações</label>
                            <!-- Class: is-invalid or valid -->
                            <textarea class="form-control" id="anotacoes" name="anotacoes" placeholder="" style="min-height:200px;">{{ old('anotacoes') }}</textarea>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="bairro_id">Bairro</label>
                            <select class="form-control" id="bairro_id" name="bairro_id" >
                               <!-- alimentando via ajax -->
                               <option value=""> Escolha uma opção! </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
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
