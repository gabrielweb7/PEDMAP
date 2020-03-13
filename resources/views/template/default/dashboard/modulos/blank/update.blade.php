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
                    <div class="boxFormGroupTitle">  Dados do Registro Blank  </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="titulo">Titulo</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="" value="@php echo (!empty(old('titulo')))?old('titulo'):$registro->titulo; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="descricao">Descrição</label>
                            <input type="text" class="form-control" id="descricao" name="descricao" placeholder="" value="@php echo (!empty(old('descricao')))?old('descricao'):$registro->descricao; @endphp">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="conteudo">Conteudo</label>

                            <!-- TextArea -->
                            <textarea id="summernote" name="conteudo" style="display:none;"> @php echo (!empty(old('conteudo')))?old('conteudo'):$registro->conteudo; @endphp </textarea>

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">

                            <label for="imagem">Imagem</label>
                            <input type="file" class="form-control" id="imagem" name="imagem" placeholder="">

                            @if(!empty($registro->imagem_src))
                                <!-- Preview Image and Delete -->
                                <div class="imagePreviewAndDelete">

                                    <!-- img -->
                                    <img src="{{ Helper::assetStorage($registro->imagem_src) }}" />

                                    <!-- actions -->
                                    <div class="actions">
                                        <a href="javascript:void(0);" title="Remover Imagem"> <i class="far fa-trash-alt"></i> </a>
                                    </div>

                                </div>
                            @endif

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->

                        </div>

                        <div class="form-group col-lg-12">

                            <div>Categorias Json</div>


                            @php
                                $categorias = json_decode($registro->categorias_json);
                                if(!is_array($categorias)) { $categorias = []; }

                            @endphp

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="banana" id="defaultCheck1" name="categorias[]" @php $value = "banana"; if(!empty(old('categorias')) && in_array($value, old('categorias'))){ echo "checked"; } else if(in_array($value, $categorias) != false && empty(old('categorias'))) { echo "checked"; } @endphp >

                                <label class="form-check-label" for="defaultCheck1">
                                    Banana
                                </label>
                            </div>

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="manga" id="defaultCheck1" name="categorias[]" @php $value = "manga"; if(!empty(old('categorias')) && in_array($value, old('categorias'))){ echo "checked"; } else if(in_array($value, $categorias) != false && empty(old('categorias'))) { echo "checked"; } @endphp >
                                <label class="form-check-label" for="defaultCheck1">
                                    Manga
                                </label>
                            </div>

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="maçã" id="defaultCheck1" name="categorias[]" @php $value = "maçã"; if(!empty(old('categorias')) && in_array($value, old('categorias'))){ echo "checked"; } else if(in_array($value, $categorias) != false && empty(old('categorias'))) { echo "checked"; } @endphp >
                                <label class="form-check-label" for="defaultCheck1">
                                    Maçã
                                </label>
                            </div>

                            <!-- checkBoxContainer -->
                            <div class="checkBoxContainer">
                                <input type="checkbox" value="uva" id="defaultCheck1" name="categorias[]" @php $value = "uva"; if(!empty(old('categorias')) && in_array($value, old('categorias'))){ echo "checked"; } else if(in_array($value, $categorias) != false && empty(old('categorias'))) { echo "checked"; } @endphp >
                                <label class="form-check-label" for="defaultCheck1">
                                    Uva
                                </label>
                            </div>

                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                    </div>

                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-primary" style="float:left;">Atualizar Registro</button>

                <!-- Delete Single Registro -->
                <a id="deleteSingle" href="{{ route('modulo-'.$menuItem->modulo_nome.'-delete', base64_encode($registro->id)) }}" style="float: right;"><button type="button" class="btn btn-danger">Deletar Registros</button></a>

                <!-- Clear Floats -->
                <div class="clear"></div>

            </form>

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection
