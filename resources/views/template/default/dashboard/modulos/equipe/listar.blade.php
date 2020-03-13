@extends('template.default.dashboard.layouts.app')

@section('title', $menuItem->nome.' > Listagem')

@section('content')

    <!-- header -->
    @include('template.default.dashboard.includes.header')

    <!-- section conteudo -->
    <section class="conteudo">

        <!-- container -->
        <div class="container">

            <!-- secBoxTitle -->
            <div class="secBoxTitle2">
            	{{ $menuItem->nome }} > Listagem
            </div>

            <!-- table actions -->
            <div class="tableActions">

                @if(Session::get('tipo') == 1 or Session::get('tipo') == 255)
                    <!-- addRegistro -->
                    <div class="addRegistro"> <a href="{{ route('modulo-'.$menuItem->modulo_nome.'-create') }}"> <button type="button" class="btn btn-primary">Novo Cadastro</button> </a> </div>
                    <!-- deletarSelecionados -->
                    <div class="deletarSelecionados" > <a href="javascript:void(0);"> <button type="button" class="btn btn-danger" id="deletarSelecionados">Deletar Registros</button> </a> </div>
                @endif

            </div>

            <!-- table-responsive -->
            <div class='table-responsive'>
                
                <!-- Parametro para datable ajax -->
                <input type="hidden" id="dataTableAjaxRoute" value="{{ route('modulo-'.$menuItem->modulo_nome.'-listar') }}" />
                <input type="hidden" id="dataAjaxRouteDelete" value="{{ route('modulo-'.$menuItem->modulo_nome.'-delete-post') }}" />
                <input type="hidden" id="dataOrderDefault" value="1" />
                <input type="hidden" id="dataOrderDefaultSentido" value="asc" />
                <input type="hidden" id="dataColumnDefs" value='[{ "width": "1%", "targets": 0 },{"className":"align-center", "targets": "align-center"},{ "orderable": false, "targets": "no-sort" }]' />

                <!-- table :: getDataAjax -->
                <table id="getDataAjax" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="no-sort align-center"> <input type="checkbox" name="selectAllRegistro" /> </th>
                            <th>E-mail</th>
                            <th class="align-center">Tipo</th>
                            <th class="align-center">Status</th>
                            <th class="align-center">Data Criação</th>
                            <th class="no-sort align-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>

                </table>
            
            </div> <!-- fim table-responsive -->

        </div> <!-- fim container -->

    </section> <!-- fim conteudo -->

@endsection