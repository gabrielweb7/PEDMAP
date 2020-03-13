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
                {{--<input type="hidden" id="ajaxRouteDeleteImage" value="{{ route('modulo-'.$menuItem->modulo_nome.'-remove-image') }}" />--}}

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
                    <div class="boxFormGroupTitle">  Dados pessoais  </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="nome">Nome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="@php echo (!empty(old('nome')))?old('nome'):$registro->nome; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" class="form-control" id="sobrenome" name="sobrenome" placeholder="" value="@php echo (!empty(old('sobrenome')))?old('sobrenome'):$registro->sobrenome; @endphp">
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                    </div>

                    <!-- boxFormGroupTitle -->
                    <div class="boxFormGroupTitle"> Dados de Acesso  </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-5">
                            <label for="email">E-mail</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="email" name="email" placeholder="" value="@php echo (!empty(old('email')))?old('email'):$registro->email; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="tipo">Tipo</label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="tipo" name="tipo" >
                                <option value="100" @if($registro->tipo == 100) selected @endif>Cliente</option>
                                <option value="1" @if($registro->tipo == 1) selected @endif>Admin</option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                    </div>

                </div>


                <!-- Submit -->
                <button type="submit" class="btn btn-primary" style="float:left;">Atualizar Registro</button>


                @if($registro->id != Session::get('id'))

                    <!-- Delete Single Registro -->
                    <a id="deleteSingle" href="{{ route('modulo-'.$menuItem->modulo_nome.'-delete', base64_encode($registro->id)) }}" style="float: right;"><button type="button" class="btn btn-danger">Deletar Registro</button></a>

                @endif
                <!-- Clear Floats -->
                <div class="clear"></div>

            </form>

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection
