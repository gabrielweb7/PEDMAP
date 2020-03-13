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
                    <div class="boxFormGroupTitle">  Dados da Pesquisa #{{ $registro->id }}  </div>


                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-2">
                            <label for="estadocivil">Estado Civil </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="estadocivil" name="estadocivil">
                                <option value="Solteiro" @if($registro->estadocivil == "Solteiro") selected @endif>Solteiro(a)</option>
                                <option value="Casado" @if($registro->estadocivil == "Casado") selected @endif>Casado(a)</option>
                                <option value="Separado" @if($registro->estadocivil == "Separado") selected @endif>Separado(a)</option>
                                <option value="Divorciado" @if($registro->estadocivil == "Divorciado") selected @endif>Divorciado(a)</option>
                                <option value="Viúvo" @if($registro->estadocivil == "Viúvo") selected @endif>Viúvo(a)</option>
                                <option value="Amasiado" @if($registro->estadocivil == "Amasiado") selected @endif>Amasiado(a)</option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="escolaridade">Escolaridade </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="escolaridade" name="escolaridade">
                                <option value="Ensino Fundamental" @if($registro->escolaridade == "Ensino Fundamental") selected @endif>Ensino Fundamental</option>
                                <option value="Ensino Medio" @if($registro->escolaridade == "Ensino Medio") selected @endif>Ensino Medio</option>
                                <option value="Ensino Superior" @if($registro->escolaridade == "Ensino Superior") selected @endif>Ensino Superior</option>
                                <option value="Ensino Fundamental Incompleto" @if($registro->escolaridade == "Ensino Fundamental Incompleto") selected @endif>E. Fundamental Incompleto</option>
                                <option value="Ensino Medio Incompleto" @if($registro->escolaridade == "Ensino Medio Incompleto") selected @endif>E. Medio Incompleto</option>
                                <option value="Ensino Superior Incompleto" @if($registro->escolaridade == "Ensino Superior Incompleto") selected @endif>E. Superior Incompleto</option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col">
                            <label for="faixasalarial">Faixa Salarial </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="faixasalarial" name="faixasalarial">
                                <option value="1" @if($registro->faixasalarial == "1") selected @endif> 1 Salário mínimo </option>
                                <option value="2" @if($registro->faixasalarial == "2") selected @endif> 2 Salários mínimo </option>
                                <option value="3" @if($registro->faixasalarial == "3") selected @endif> 3 Salários mínimo </option>
                                <option value="4" @if($registro->faixasalarial == "4") selected @endif> 4 Salários mínimo </option>
                                <option value="5" @if($registro->faixasalarial == "5") selected @endif> + que 5 Salários </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col">
                            <label for="sexo">Sexo </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="sexo" name="sexo" >
                                <option value="Feminino" @if($registro->sexo == "Feminino") selected @endif> Feminino </option>
                                <option value="Masculino" @if($registro->sexo == "Masculino") selected @endif> Masculino </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col">
                            <label for="idade">Idade</label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="idade" name="idade">
                                <option value="12-19" @if($registro->idade == "12-19") selected @endif> 12 á 19 </option>
                                <option value="20-29" @if($registro->idade == "20-29") selected @endif> 20 á 29 </option>
                                <option value="30-39" @if($registro->idade == "30-39") selected @endif> 30 á 39 </option>
                                <option value="40-49" @if($registro->idade == "40-49") selected @endif> 40 á 49 </option>
                                <option value="50+" @if($registro->idade == "50+") selected @endif> 50+ </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                    </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label for="votariaProporcional">Em quem você votaria proporcional</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="votariaProporcional" name="votariaProporcional" value="@php echo (!empty(old('votariaProporcional')))?old('votariaProporcional'):$registro->votariaProporcional; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="naoVotariaProporcional">Em quem você não votaria proporcional</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="naoVotariaProporcional" name="naoVotariaProporcional" value="@php echo (!empty(old('naoVotariaProporcional')))?old('naoVotariaProporcional'):$registro->naoVotariaProporcional; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-6">
                            <label for="votariaMajor">Em quem você votaria majoritário </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="votariaMajor" name="votariaMajor">
                                <option value="1" @if($registro->votariaMajor == "1") selected @endif> Option 1 </option>
                                <option value="2" @if($registro->votariaMajor == "2") selected @endif> Option 2 </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="naoVotariaMajor">Em quem você não votaria majoritário </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="naoVotariaMajor" name="naoVotariaMajor">
                                <option value="1" @if($registro->naoVotariaMajor == "1") selected @endif> Option 1 </option>
                                <option value="2" @if($registro->naoVotariaMajor == "2") selected @endif> Option 2 </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="localizacao">Localização </label>
                            <input type="text" class="form-control" id="localizacao" name="localizacao" value="@php echo (!empty(old('localizacao')))?old('localizacao'):$registro->localizacao; @endphp">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-12">

                            <div><b>Principais problemas do bairro</b></div>

                            @php
                                $problemas = $registro->problemas;
                                #if(!is_array($categorias)) { $categorias = []; }
                                $arrayCat = [];
                                foreach($problemas as $problema) {
                                    $arrayCat[] = $problema->id;
                                }
                            @endphp

                            @foreach(App\ProblemasBairro::where('visivel','=','1')->whereNull('datahora_deleted')->get() as $problema)
                                <!-- checkBoxContainer -->
                                    <div class="checkBoxContainer">
                                        <input type="checkbox" value="{{ base64_encode($problema->id) }}" id="defaultCheck_{{ $problema->id }}" name="problemas[]" @if(in_array($problema->id, $arrayCat)) checked @endif>
                                        <label class="form-check-label" for="defaultCheck_{{ $problema->id }}">
                                            {{ $problema->problema }}
                                        </label>
                                    </div>
                            @endforeach

                        <!-- <div class="valid-feedback">Este e-mail já existe em nosso banco de dados.</div>-->
                        </div>

                        <div class="form-group col-lg-12">

                            <div> <b>Criado em</b></div>
                            <div> {{ $registro->datahora->format('H:i:s d/m/Y') }}</div>

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
