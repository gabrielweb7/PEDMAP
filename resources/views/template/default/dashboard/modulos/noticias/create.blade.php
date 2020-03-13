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
                            <label for="retranca">Retranca</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="retranca" name="retranca" placeholder="" value="{{ old('retranca') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="resumo">Resumo</label>
                            
                            <!-- TextArea -->
                            <textarea id="summernote" name="resumo" style="display:none;"> {{ old('resumo') }} </textarea>

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="divulgacao">Divulgação</label>
                            <input type="text" class="form-control" id="divulgacao" name="divulgacao" placeholder="" value="{{ old('divulgacao') }}">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="descricao">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="{{ old('bairro') }}">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="favorita">Importante</label>
                            <select class="form-control" id="favorita" name="favorita">
                                <option value="1"> Sim </option>
                                <option value="0" selected> Não </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>


                        @php 
                            if(Session::get('tipo') == '255') { 
                        @endphp
                        <div class="form-group col-lg-2">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1" selected> Publico </option>
                                <option value="0"> Privado </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>
                        @php
                            }
                        @endphp

                        <div class="form-group col-lg-6">
                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" placeholder="">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="arquivo">Arquivo</label>
                            <input type="file" class="form-control" id="arquivo" name="arquivo" placeholder="">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">

                            <div><b>Categorias</b></div>

                            <!-- <input type="text" class="form-control" id="categorias" name="categorias" placeholder=""> -->

                            @foreach(App\Noticiascat::where('visivel','=','1')->whereNull('datahora_deleted')->get() as $categoria)
                                 <!-- checkBoxContainer -->
                                <div class="checkBoxContainer">
                                    <input type="checkbox" value="{{ base64_encode($categoria->id) }}" id="defaultCheck_{{ $categoria->id }}" name="categorias[]">
                                    <label class="form-check-label" for="defaultCheck_{{ $categoria->id }}">
                                        {{ $categoria->categoria }}
                                    </label>
                                </div>
                            @endforeach



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
