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
                    <div class="boxFormGroupTitle">  Dados do Registro Blank  </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="titulo">Titulo</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="" value="{{ old('titulo') }}">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="" value="{{ old('descricao') }}">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="conteudo">Conteudo</label>
                            
                            <!-- TextArea -->
                            <textarea id="summernote" name="conteudo" style="display:none;"> {{ old('conteudo') }} </textarea>

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" placeholder="">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">

                            <div>Categorias Json</div>

                            <!-- <input type="text" class="form-control" id="categorias" name="categorias" placeholder=""> -->

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="banana" id="defaultCheck1" name="categorias[]">
                                <label class="form-check-label" for="defaultCheck1">
                                    Banana
                                </label>
                            </div>

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="manga" id="defaultCheck1" name="categorias[]">
                                <label class="form-check-label" for="defaultCheck1">
                                    Manga
                                </label>
                            </div>

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="maçã" id="defaultCheck1" name="categorias[]">
                                <label class="form-check-label" for="defaultCheck1">
                                    Maçã
                                </label>
                            </div>

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="uva" id="defaultCheck1" name="categorias[]">
                                <label class="form-check-label" for="defaultCheck1">
                                    Uva
                                </label>
                            </div>

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
