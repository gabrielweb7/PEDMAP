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

                <input type="hidden" name="datahora_open" value="{{ date('Y/m/d H:i:s') }}">

                <!-- boxFormGroup -->
                <div class="boxFormGroup"> 

                    <!-- boxFormGroupTitle -->
                    <div class="boxFormGroupTitle">  Dados da Pesquisa  </div>

                    <!-- row -->
                    <div class="row">

                        <div class="form-group col-lg-2">
                            <label for="estadocivil">Estado Civil </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="estadocivil" name="estadocivil">
                                <option value="Solteiro" selected>Solteiro(a)</option>
                                <option value="Casado">Casado(a)</option>
                                <option value="Separado">Separado(a)</option>
                                <option value="Divorciado">Divorciado(a)</option>
                                <option value="Viúvo">Viúvo(a)</option>
                                <option value="Amasiado">Amasiado(a)</option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-3">
                            <label for="escolaridade">Escolaridade </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="escolaridade" name="escolaridade">
                                <option value="Ensino Fundamental" selected>Ensino Fundamental</option>
                                <option value="Ensino Medio">Ensino Medio</option>
                                <option value="Ensino Superior">Ensino Superior</option>
                                <option value="Ensino Fundamental Incompleto">E. Fundamental Incompleto</option>
                                <option value="Ensino Medio Incompleto">E. Medio Incompleto</option>
                                <option value="Ensino Superior Incompleto">E. Superior Incompleto</option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col">
                            <label for="faixasalarial">Faixa Salarial </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="faixasalarial" name="faixasalarial">
                                <option value="1" selected> 1 Salário mínimo </option>
                                <option value="2"> 2 Salários mínimo </option>
                                <option value="3"> 3 Salários mínimo </option>
                                <option value="4"> 4 Salários mínimo </option>
                                <option value="5"> + que 5 Salários </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col">
                            <label for="sexo">Sexo </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="sexo" name="sexo" >
                                <option value="Feminino" selected> Feminino </option>
                                <option value="Masculino"> Masculino </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col">
                            <label for="idade">Idade</label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="idade" name="idade">
                                <option value="12-19" selected> 12 á 19 </option>
                                <option value="20-29"> 20 á 29 </option>
                                <option value="30-39"> 30 á 39 </option>
                                <option value="40-49"> 40 á 49 </option>
                                <option value="50+"> 50+ </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                    </div>
                    <!-- row -->
                    <div class="row">




                        <div class="form-group col-lg-6">
                            <label for="votariaProporcional">Em quem você votaria proporcional</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="votariaProporcional" name="votariaProporcional">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="naoVotariaProporcional">Em quem você não votaria proporcional</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="naoVotariaProporcional" name="naoVotariaProporcional">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-6">
                            <label for="votariaMajor">Em quem você votaria majoritário </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="votariaMajor" name="votariaMajor">
                                <option value="1" selected> Option 1 </option>
                                <option value="2"> Option 2 </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="naoVotariaMajor">Em quem você não votaria majoritário </label>
                            <!-- Class: is-invalid or valid -->
                            <select class="form-control" id="naoVotariaMajor" name="naoVotariaMajor">
                                <option value="1" selected> Option 1 </option>
                                <option value="2"> Option 2 </option>
                            </select>
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-12">
                            <label for="localizacao">Localização</label>
                            <!-- Class: is-invalid or valid -->
                            <input type="text" class="form-control" id="localizacao" name="localizacao">
                            <!-- <div class="invalid-feedback">Este e-mail já existe em nosso banco de dados.</div> -->
                        </div>


                        <div class="form-group col-lg-12">

                            <div><b>Principais problemas do bairro</b></div>

                            <!-- <input type="text" class="form-control" id="categorias" name="categorias" placeholder=""> -->

                            @foreach(App\ProblemasBairro::where('visivel','=','1')->whereNull('datahora_deleted')->get() as $problema)
                                    <!-- checkBoxContainer -->
                                    <div class="checkBoxContainer">
                                        <input type="checkbox" value="{{ base64_encode($problema->id) }}" id="defaultCheck_{{ $problema->id }}" name="problemas[]">
                                        <label class="form-check-label" for="defaultCheck_{{ $problema->id }}">
                                            {{ $problema->problema }}
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
