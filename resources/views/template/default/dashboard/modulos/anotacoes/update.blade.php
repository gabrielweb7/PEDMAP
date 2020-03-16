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

                <!-- Route para Deletar Arquivo do registro via Ajax -->
                <input type="hidden" id="ajaxRouteDeleteArquivo" value="{{ route('modulo-'.$menuItem->modulo_nome.'-remove-arquivo') }}" />

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

                           <!-- row -->
                    <div class="row">

                      <!-- Input -->
                      <div class="form-group col-lg-12">
                            <label for="nome">Anotações</label>
                            <!-- Class: is-invalid or valid -->
                            <textarea class="form-control" id="anotacoes" name="anotacoes" style='min-height:200px;'> @php echo (!empty(old('anotacoes')))?old('anotacoes'):$registro->anotacoes; @endphp </textarea>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="bairro_id">Bairro</label>
                            <select class="form-control" id="bairro_id" name="bairro_id" >
                               <!-- alimentando via ajax -->
                               <option value="{{ $registro->bairro()->id }}" selected> {{ $registro->bairro()->bairro }} </option>
                            </select>
                            <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>


                        <div class="form-group col-lg-3">
                            <div> <b>Criado em</b></div>
                            <div> {{ $registro->datahora->format('d/m/Y - H:i') }}</div>
                        </div>

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
