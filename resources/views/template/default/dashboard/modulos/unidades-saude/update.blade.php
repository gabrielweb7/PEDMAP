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
                {{--<input type="hidden" id="ajaxRouteDeleteImage" value="{{ //route('modulo-'.$menuItem->modulo_nome.'-remove-image') }}" />--}}

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

                        <div class="form-group col-lg-6">
                            <label for="categoria">Nome</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="" value="@php echo (!empty(old('nome')))?old('nome'):$registro->nome; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-2">
                            <label for="categoria">Código</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="cod" name="cod" placeholder="" value="@php echo (!empty(old('cod')))?old('cod'):$registro->cod; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Telefone</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="telefone" name="telefone" placeholder="" value="@php echo (!empty(old('telefone')))?old('telefone'):$registro->telefone; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Endereço</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="endereco" name="endereco" placeholder="" value="@php echo (!empty(old('endereco')))?old('endereco'):$registro->endereco; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Bairro</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="bairro" name="bairro" placeholder="" value="@php echo (!empty(old('bairro')))?old('bairro'):$registro->bairro; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-4">
                            <label for="categoria">Cidade</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="cidade" name="cidade" placeholder="" value="@php echo (!empty(old('cidade')))?old('cidade'):$registro->cidade; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>
                       

                        <div class="form-group col-lg-6">
                            <label for="categoria">Estrutura Física</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="estrutura_fisica" name="estrutura_fisica" placeholder="" value="@php echo (!empty(old('estrutura_fisica')))?old('estrutura_fisica'):$registro->estrutura_fisica; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="categoria">Acessibilidade</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="adap_defic_fisic_idosos" name="adap_defic_fisic_idosos" placeholder="" value="@php echo (!empty(old('adap_defic_fisic_idosos')))?old('adap_defic_fisic_idosos'):$registro->adap_defic_fisic_idosos; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="categoria">Equipamentos</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="equipamentos" name="equipamentos" placeholder="" value="@php echo (!empty(old('equipamentos')))?old('equipamentos'):$registro->equipamentos; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-6">
                            <label for="categoria">Medicamentos</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="medicamentos" name="medicamentos" placeholder="" value="@php echo (!empty(old('medicamentos')))?old('medicamentos'):$registro->medicamentos; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <!-- <div class="form-group col-lg-6">
                            <label for="visivel">Visibilidade</label>
                            <select class="form-control" id="visivel" name="visivel">
                                <option value="{{ base64_encode('1') }}" @if( (empty(old('visivel')) && $registro->visivel == "1") or (!empty(old('visivel')) && base64_decode(old('visivel')) == 1) ) selected @endif> Ativo</option>
                                <option value="{{ base64_encode('0') }}" @if( (empty(old('visivel')) && $registro->visivel == "0") or (!empty(old('visivel')) && base64_decode(old('visivel')) == 0) ) selected @endif> Desativado</option>
                            </select>
                        </div> -->

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
